
<?php
class Address
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllAddresses()
    {
        $stmt = $this->db->prepare("SELECT * FROM addresses");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
