<?php
    require_once 'baseClass.class.php';

    /*
     * Class firstPersonView
     * Permet de récupérer les images de la map et de la boussole
     */
    class firstPersonView extends baseClass{

        /*
         * @Param array $base 
         * Récupère l'image de la map en fonction du map id actuel
         * Return $img_path['path']
         */
        public function getView($base) {
            $sql = $base ->_dbh->prepare('SELECT path FROM images WHERE map_id = :mapid');
            $sql -> bindParam(':mapid', $base->_mapId, PDO::PARAM_INT);
            $sql -> execute();
            $img_path = $sql->fetch(PDO::FETCH_ASSOC);

            // error_log("Img_path : " . print_r($img_path, 1));

            return $img_path['path'];
        }

        /*
         * @Param array $base
         * Récupère l'image de la boussole en fonction de l'orientation 
         * Return $compass_path['c_path']
         */
        public function getCompass($base){
            // error_log(print_r($base->_currentAngle, 1));

            $sql2 = $base->_dbh->prepare("SELECT * FROM compass WHERE map_direction = :currentAngle");
            $sql2 -> bindParam(':currentAngle', $base->_currentAngle, PDO::PARAM_INT);
            $sql2 -> execute();
            $compass_path = $sql2->fetch(PDO::FETCH_ASSOC);

            // error_log(print_r($compass_path['c_path'], 1));
            
            return $compass_path['c_path'];
        }
    }
?>