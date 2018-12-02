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

                $this->setData($results[0]);

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

                $this->setData($results[0]);

            }else{
                throw new Exception("Login e/ou Senha inválidos!");
            }
        }

        // atribuir valores ao ojbeto Usuario
        public function setData($data){

            $this->setIdusuario($data['idusuario']);
            $this->setDeslogin($data['deslogin']);
            $this->setDessenha($data['dessenha']);
            $this->setDtcadastro(new Datetime($data['dtcadastro']));

        }

        // insere um novo usuario
        public function insert(){

                $sql = new Sql();

                // a procedure está no banco
                $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
                    ':LOGIN'=>$this->getDeslogin(),
                    ':PASSWORD'=>$this->getDessenha()
                ));

                if (count($results) > 0) {
                    $this->setData($results[0]);
                }
        }

        // edita um usuario
        public function update($login, $password){

            $this->setDeslogin($login);
            $this->setDessenha($password);

            $sql = new Sql();

            $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
                ':LOGIN'=>$this->getDeslogin(),
                ':PASSWORD'=>$this->getDessenha(),
                ':ID'=>$this->getIdusuario()
            ));
        }

        // metodo construtor para automatizar o metodo insert()
        public function __construct($login = "", $password = ""){
            
            $this->setDeslogin($login);
            $this->setDessenha($password);
            
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