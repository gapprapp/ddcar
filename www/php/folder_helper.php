<?php
/**
 * folder_helper.php
 * ฟังก์ชันช่วยดึงโครงสร้างลำดับชั้นโฟลเดอร์/หมวดหมู่ของสินค้า (Folder Path Hierarchy)
 */

if (!function_exists('get_products_folder_paths')) {
    /**
     * ดึงเส้นทางโฟลเดอร์ของสินค้าหลายรายการพร้อมกัน (Batch Fetch)
     *
     * @param mysqli $conn การเชื่อมต่อฐานข้อมูล
     * @param array $prod_ids อาร์เรย์ของ prod_id
     * @return array ผลลัพธ์ในรูปแบบ [prod_id => ['path' => 'Toyota > Fortuner > กระจังหน้า', 'chain' => [...]]]
     */
    function get_products_folder_paths($conn, $prod_ids) {
        $result_map = array();
        if (empty($prod_ids) || !is_array($prod_ids)) {
            return $result_map;
        }

        // เตรียม prod_id ป้องกัน SQL Injection
        $clean_ids = array();
        foreach ($prod_ids as $id) {
            $id_str = trim((string)$id);
            if ($id_str !== '') {
                $clean_ids[] = "'" . mysqli_real_escape_string($conn, $id_str) . "'";
                $result_map[$id_str] = array(
                    'path' => '',
                    'chain' => array()
                );
            }
        }

        if (empty($clean_ids)) {
            return $result_map;
        }

        $id_list_str = implode(',', $clean_ids);

        // 1. ดึงด้วยวิธี MPTT (Modified Preorder Tree Traversal)
        // โหนดแม่ (ancestor) จะมี node.lft อยู่ระหว่าง parent.lft และ parent.rgt
        $sql_mptt = "SELECT 
                        node.title AS prod_id,
                        parent.title AS folder_title,
                        parent.lft AS folder_lft
                     FROM tree AS node
                     INNER JOIN tree AS parent ON node.lft BETWEEN parent.lft AND parent.rgt
                     WHERE node.title IN ($id_list_str)
                       AND parent.title != node.title
                       AND parent.title != 'car'
                     ORDER BY node.title ASC, parent.lft ASC";

        $res_mptt = mysqli_query($conn, $sql_mptt);
        if ($res_mptt && mysqli_num_rows($res_mptt) > 0) {
            while ($row = mysqli_fetch_assoc($res_mptt)) {
                $pid = (string)$row['prod_id'];
                if (isset($result_map[$pid])) {
                    $result_map[$pid]['chain'][] = $row['folder_title'];
                }
            }
        }

        // จัดรูปข้อความ path ของสินค้าที่ดึงได้จาก MPTT
        foreach ($result_map as $pid => $data) {
            if (!empty($data['chain'])) {
                $result_map[$pid]['path'] = implode(' > ', $data['chain']);
            }
        }

        // 2. Fallback: สำหรับสินค้าที่ MPTT ไม่พบข้อมูล ให้ไล่จาก parent_title ขึ้นไป
        $missing_pids = array();
        foreach ($result_map as $pid => $data) {
            if (empty($data['path'])) {
                $missing_pids[] = "'" . mysqli_real_escape_string($conn, $pid) . "'";
            }
        }

        if (!empty($missing_pids)) {
            $missing_str = implode(',', $missing_pids);
            $sql_direct = "SELECT title AS prod_id, parent_title FROM tree WHERE title IN ($missing_str)";
            $res_direct = mysqli_query($conn, $sql_direct);
            if ($res_direct && mysqli_num_rows($res_direct) > 0) {
                while ($r = mysqli_fetch_assoc($res_direct)) {
                    $pid = (string)$r['prod_id'];
                    $curr_parent = trim((string)$r['parent_title']);
                    if (!empty($curr_parent) && $curr_parent !== 'car') {
                        $chain = array();
                        $visited = array();
                        $steps = 0;
                        while (!empty($curr_parent) && $curr_parent !== 'car' && $steps < 10 && !isset($visited[$curr_parent])) {
                            $visited[$curr_parent] = true;
                            $steps++;
                            array_unshift($chain, $curr_parent);
                            $curr_safe = mysqli_real_escape_string($conn, $curr_parent);
                            $res_up = mysqli_query($conn, "SELECT parent_title FROM tree WHERE title = '$curr_safe' LIMIT 1");
                            if ($res_up && $row_up = mysqli_fetch_assoc($res_up)) {
                                $curr_parent = trim((string)$row_up['parent_title']);
                            } else {
                                break;
                            }
                        }
                        if (!empty($chain)) {
                            $result_map[$pid]['chain'] = $chain;
                            $result_map[$pid]['path'] = implode(' > ', $chain);
                        }
                    }
                }
            }
        }

        return $result_map;
    }
}

if (!function_exists('get_product_folder_path')) {
    /**
     * ดึงเส้นทางโฟลเดอร์ของสินค้า 1 ชิ้น
     */
    function get_product_folder_path($conn, $prod_id) {
        $map = get_products_folder_paths($conn, array($prod_id));
        $pid_str = (string)$prod_id;
        return isset($map[$pid_str]) ? $map[$pid_str] : array('path' => '', 'chain' => array());
    }
}
?>
