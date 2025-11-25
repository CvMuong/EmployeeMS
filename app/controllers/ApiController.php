<?php
class ApiController {
    // GET ?route=api/employees&limit=...&page=...
    public function employees() {
        header('Content-Type: application/json');
        $limit = (int)($_GET['limit'] ?? 10);
        $page = max(1,(int)($_GET['page'] ?? 1));
        $offset = ($page-1)*$limit;
        $keyword = $_GET['keyword'] ?? null;
        $data = Employee::all($limit,$offset,$keyword);
        $total = Employee::countAll($keyword);
        echo json_encode(['data'=>$data,'total'=>$total,'page'=>$page,'limit'=>$limit]);
    }
}
