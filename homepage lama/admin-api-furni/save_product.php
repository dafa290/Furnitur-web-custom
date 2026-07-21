<?php
require_once '../config.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

try {
    if(!empty($data['id'])) {
        // Update
        $stmt = $db->prepare("UPDATE products SET name=?, category=?, price=?, image=?, description=? WHERE id=?");
        $stmt->execute([
            $data['name'], $data['category'], $data['price'], 
            $data['image'], $data['description'], $data['id']
        ]);
    } else {
        // Insert
        $stmt = $db->prepare("INSERT INTO products (name, category, price, image, description) VALUES (?,?,?,?,?)");
        $stmt->execute([
            $data['name'], $data['category'], $data['price'], 
            $data['image'], $data['description']
        ]);
    }
    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>