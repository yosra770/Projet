<?php
require_once("../../config/db.php");

class User
{
    private $pdo;

    public function __construct()
    {
        $cnx = new Connexion();
        $this->pdo = $cnx->CNXbase();
    }

    // 🔹 récupérer user
    public function getUser($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🔹 modifier user + photo
    public function updateUser($id, $data, $file)
    {
        // garder ancienne photo
        $user = $this->getUser($id);
        $photo = $user['photo'];

        // upload nouvelle photo
        if (!empty($file['photo']['name'])) {

            $filename = time() . "_" . $file['photo']['name'];
            $tmp = $file['photo']['tmp_name'];

            move_uploaded_file($tmp, "../../uploads/" . $filename);

            $photo = $filename;
        }

        $stmt = $this->pdo->prepare("
            UPDATE utilisateur 
            SET nom=?, prenom=?, email=?, role=?, status=?, photo=? 
            WHERE id=?
        ");

        return $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['role'],
            $data['status'],
            $photo,
            $id
        ]);
    }

    // 🔹 supprimer user
    public function deleteUser($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM utilisateur WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>