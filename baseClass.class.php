<?php
    require_once 'dataBase.class.php';

    /*
     * Class baseClass
     * Récupère les coordonnées et effectue les déplacements  
     */
    class baseClass {

        /*
        * @var int Récupère la position X
        */
        protected $_currentX; 

        /*
        * @var int Récupère la position Y
        */
        protected $_currentY; 

        /*
        * @var int Récupère l'angle de vue
        */
        protected $_currentAngle;

        /*
        * @var int Récupère le map id
        */
        protected $_mapId; 

        /*
        * @var array Effectue la connexion à la base de donnée
        */
        protected $_dbh; 
        

        public function __construct() {
            $this->_dbh = new dataBase();
        }

                                    /* Setters et Getters des propriétés protected */

        /*
        *@param int défini la position sur l'axe X
        */
        public function setCurrentX(int $_currentX) {
            $this -> _currentX = $_currentX;
        }

        /*
        *@return la position sur l'axe X
        */
        public function getCurrentX() {
            return $this -> _currentX;
        }

        /*
        *@param int défini la position sur l'axe Y
        */
        public function setCurrentY(int $_currentY) {
            $this -> _currentY = $_currentY;
        }

        /*
        *@return la position sur l'axe Y
        */
        public function getCurrentY() {
            return $this -> _currentY;
        }

        /*
        *@param int défini l'angle de vue
        */
        public function setCurrentAngle(int $_currentAngle) {
            $this -> _currentAngle = $_currentAngle;
        }

        /*
        *@return l'angle de vue
        */
        public function getCurrentAngle() {
            return $this -> _currentAngle;
        }

        /*
        *@param int défini le map id
        */
        public function setCurrentMapId(int $_mapId){
            $this -> _mapId = $_mapId;
        }

        /*
        *@return le map id
        */
        public function getCurrentMapId(){
            return $this -> _mapId;
        }
        

        //Initialise des valeurs par défauts
        public function init() {
            $this->_currentX = 1;
            $this->_currentY = 1;
            $this->_currentAngle = 0;
            $this->_mapId = 1;
            $_SESSION = [];
        }

        
                                        /* Méthode privée pour vérifier si un mouvement est possible */

        private function _checkMove(int $newX, int $newY) {

            // Interroger la base de données pour vérifier si le mouvement est possible
            $stmt = $this -> _dbh -> prepare('SELECT id FROM map WHERE coordX = :newX AND coordY = :newY AND direction = :currentAngle');
            $stmt-> bindParam(':newX', $newX, PDO::PARAM_INT);
            $stmt-> bindParam(':newY', $newY, PDO::PARAM_INT);
            $stmt-> bindParam(':currentAngle', $this->_currentAngle, PDO::PARAM_INT);
            $stmt-> execute();

            $res = $stmt -> fetchAll(PDO::FETCH_ASSOC);

            // error_log("check result : " . print_r($res, 1));
            
            if(!empty($res)) {
                return true;
            } else {
                return false;
            }
        }

                                    /* Méthodes Check pour vérifier sur l'action est possible */

        public function checkForward () {
            $newX = $this->_currentX;
            $newY = $this->_currentY;

            switch($this->_currentAngle){
                case 0 : {
                    $newX++;
                    break;
                }
                case 90 : {
                    $newY++;
                    break;
                }
                case 180 : {
                    $newX--;
                    break;
                }
                case 270 : {
                    $newY--;
                    break;
                }
            }
            return $this->_checkMove($newX, $newY);
        }

        public function checkBack () {
            $newX = $this->_currentX;
            $newY = $this->_currentY;
            switch($this->_currentAngle){
                case 0 : {
                    $newX--;
                    break;
                }
                case 90 : {
                    $newY--;
                    break;
                }
                case 180 : {
                    $newX++;
                    break;
                }
                case 270 : {
                    $newY++;
                    break;
                }
            }
            return $this->_checkMove($newX, $newY); 
        }

        public function checkRight () {
            $newX = $this->_currentX;
            $newY = $this->_currentY;
            switch($this->_currentAngle){
                case 0 : {
                    $newY--;
                    break;
                }
                case 90 : {
                    $newX++;
                    break;
                }
                case 180 : {
                    $newY++;
                    break;
                }
                case 270 : {
                    $newX--;
                    break;
                }
            }
            return $this->_checkMove($newX, $newY);
        }

        public function checkLeft () {
            $newX = $this->_currentX;
            $newY = $this->_currentY;
            switch($this->_currentAngle){
                case 0 : {
                    $newY++;
                    break;
                }
                case 90 : {
                    $newX--;
                    break;
                }
                case 180 : {
                    $newY--;
                    break;
                }
                case 270 : {
                    $newX++;
                    break;
                }
            }
            return $this->_checkMove($newX, $newY);
        }

        /*
         * @Param int $newX Récupère la position X
         * @Param int $newY Récupère la position Y
         * @Param int $newAngle Récupère l'angle de vue
         * Récupère le map id en fonction de des coordonnées et de l'angle de vue
         * Return $_mapId['id']
         */
        public function getMapIdWithCoordinate($newX, $newY, $newAngle){
            $sql = $this -> _dbh -> prepare('SELECT * FROM map WHERE coordX = :X AND coordY = :Y AND direction = :Angle');
            $sql -> bindParam(':X', $newX, PDO::PARAM_INT);
            $sql -> bindParam(':Y', $newY, PDO::PARAM_INT);
            $sql -> bindParam(':Angle', $newAngle, PDO::PARAM_INT);
            $sql -> execute();
            $_mapId = $sql -> fetch(PDO::FETCH_ASSOC);

            // error_log(print_r($_mapId, 1));

            return $_mapId['id'];
            
        }
                                        /* Méthodes Go pour effectuer les déplacements */
        public function goForward() {
            $newX = $this -> _currentX;
            $newY = $this -> _currentY;
            if ($this -> checkForward()) {
                switch($this -> _currentAngle) {
                    case 0:
                        $newX++;
                        break;
                    case 90:
                        $newY++;
                        break;
                    case 180:
                        $newX--;
                        break;
                    case 270:
                        $newY--;
                        break;
                }
                $this->_mapId = $this -> getMapIdWithCoordinate($newX, $newY, $this -> _currentAngle);
                $this -> _currentX = $newX;
                $this -> _currentY = $newY;

            }
        }

        public function goBack() {
            $newX = $this -> _currentX;
            $newY = $this -> _currentY;
            if ($this -> checkBack()) {
                switch($this -> _currentAngle) {
                    case 0:
                        $newX--;
                        break;
                    case 90:
                        $newY--;
                        break;
                    case 180:
                        $newX++;
                        break;
                    case 270:
                        $newY++;
                        break;
                }
                $this->_mapId = $this -> getMapIdWithCoordinate($newX, $newY, $this -> _currentAngle);
                $this -> _currentX = $newX;
                $this -> _currentY = $newY;
            }
        }

        public function goRight() {
            $newX = $this -> _currentX;
            $newY = $this -> _currentY;
            if ($this -> checkRight()) {
                switch($this -> _currentAngle) {
                    case 0:
                        $newY--;
                        break;
                    case 90:
                        $newX++;
                        break;
                    case 180:
                        $newY++;
                        break;
                    case 270:
                        $newX--;
                        break;
                }
                $this->_mapId = $this -> getMapIdWithCoordinate($newX, $newY, $this -> _currentAngle);
                $this -> _currentX = $newX;
                $this -> _currentY = $newY;
            }
        }

        public function goLeft() {
            $newX = $this -> _currentX;
            $newY = $this -> _currentY;
            if ($this -> checkLeft()) {
                switch($this -> _currentAngle) {
                    case 0:
                        $newY++;
                        break;
                    case 90:
                        $newX--;
                        break;
                    case 180:
                        $newY--;
                        break;
                    case 270:
                        $newX++;
                        break;
                }
                $this->_mapId = $this -> getMapIdWithCoordinate($newX, $newY, $this -> _currentAngle);
                $this -> _currentX = $newX;
                $this -> _currentY = $newY;
            }
        }

        public function turnRight() {
            $newAngle = $this -> _currentAngle;
            switch($this -> _currentAngle) {
                case 0:
                    $newAngle += 270;
                    break;
                case 270:
                    $newAngle -= 90;
                    break;
                case 180:
                    $newAngle -= 90;
                    break;
                case 90:
                    $newAngle -= 90;
                    break;
            }
            $this->_mapId = $this -> getMapIdWithCoordinate($this->_currentX, $this->_currentY, $newAngle);
            $this -> _currentAngle = $newAngle;
        }

        public function turnLeft() {
            $newAngle = $this -> _currentAngle;
            switch($this -> _currentAngle) {
                case 0:
                    $newAngle += 90;
                    break;
                case 90:
                    $newAngle += 90;
                    break;
                case 180:
                    $newAngle += 90;
                    break;
                case 270:
                    $newAngle -= 270;
                    break;
            }
            
            $this->_mapId = $this -> getMapIdWithCoordinate($this->_currentX, $this->_currentY, $newAngle);
            $this -> _currentAngle = $newAngle;
        }
    }
?>