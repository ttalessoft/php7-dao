<?php

    class Usuario{

        private $idusuario;
        private $deslogin;
        private $dessenha;
        private $dtcadastro;

        public function getIdusuario(){
            return $this->idusuario;
        }
        public function setIdusuario($idusuario){
            $this->idusuario = $idusuario;
        }

        public function getDeslogin(){
            return $this->deslogin;
        }
        public function setDeslogin($deslogin){
            $this->deslogin = $deslogin;
        }

        public function getDessenha(){
            return $this->dessenha;
        }
        public function setDessenha($dessenha){
            $this->dessenha = $dessenha;
        }

        public function getDtcadastro(){
            return $this->dtcadastro;
        }
        public function setDtcadastro($dtcadastro){
            $this->dtcadastro = $dtcadastro;
        }

        // pega apenas um usuário a partir do parametro
        public function loadbyId($id){
            
            $sql = new Sql();

            $results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
                ":ID"=>$id
            ));

            if(isset($results[0])){

                $row = $results[0];

                $this->setIdusuario($row['idusuario']);
                $this->setDeslogin($row['deslogin']);
                $this->setDessenha($row['dessenha']);
                $this->setDtcadastro(new DateTime($row['dtcadastro']));

            }

        }

        // busca o usuario pelo login
        public static function search($login){

            $sql = new Sql();

            return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
                ':SEARCH'=>'%' . $login . '%'
            ));
        }

        // pega a lista de todos os usuarios é static pois nao tem $this no metodo
        public static function getList(){

            $sql = new Sql();

            return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
        }

        // valida um acesso com credenciais
        public function login($login, $password){

            $sql = new Sql();

            $results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :DESLOGIN AND dessenha = :DESSENHA", array(
                ":DESLOGIN"=>$login,
                ":DESSENHA"=>$password
            ));

            if (count($results) > 0) {
                $row = $results[0];

                $this->setIdusuario($row['idusuario']);
                $this->setDeslogin($row['deslogin']);
                $this->setDessenha($row['dessenha']);
                $this->setDtcadastro(new DateTime($row['dtcadastro']));

            }else{
                throw new Exception("Login e/ou Senha inválidos!");
            }
        }

        public function __toString(){
            return json_encode(array(
                "idusuario"=>$this->getIdusuario(),
                "deslogin"=>$this->getDeslogin(),
                "dessenha"=>$this->getDessenha(),
                "dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
            ));
        }
    }