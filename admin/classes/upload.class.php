<?php

class Upload
{

    public function __construct()
    {
        $this->setDir("../site/images/posts/");
        $this->setID("");
        $this->setImagem("");
        $this->setTitulo("");
        $this->setAlt("");
        $this->setIdPost("");
    }

    public function setDir($dir)
    {
        $this->dir = $dir;
    }
    public function getDir()
    {
        return $this->dir;
    }

    public function setID($id)
    {
        $this->id = $id;
    }
    public function getID()
    {
        return $this->id;
    }

    public function setImagem($img)
    {
        $this->img = $img;
    }
    public function getImagem()
    {
        return $this->img;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }
    public function getTitulo()
    {
        return $this->titulo;
    }

    public function setAlt($alt)
    {
        $this->alt = $alt;
    }
    public function getAlt()
    {
        return $this->alt;
    }

    public function setIdPost($idpost)
    {
        $this->idpost = $idpost;
    }
    public function getIdPost()
    {
        return $this->idpost;
    }

    public function InsertImg()
    {
      include("../configs/conexao.class.php");
        $parametros = array(
            ":img"    => $this->img,
            ":alt"    => $this->alt,
            ":titulo" => $this->titulo,
            ":idpost" => $this->idpost
        );

        $ex = $pdo->prepare("INSERT INTO imagem (post_id, imagem_title, imagem_alt, imagem_link)
            VALUES (:idpost, :titulo, :alt, :img) ");
        $ex->execute($parametros);

    }

    public function UpdateImg()
    {
      include("../configs/conexao.class.php");
        $parametros = array(
            ":img"    => $this->img,
            ":alt"    => $this->alt,
            ":titulo" => $this->titulo,
            ":idpost" => $this->idpost
        );

        $ex = $pdo->prepare("UPDATE imagem
            SET imagem_title = :titulo, imagem_alt = :alt, imagem_link = :img
            WHERE post_id = :idpost ");
        $ex->execute($parametros);
    }

    public function UploadImage($img_name, $img_temp)
    {
        date_default_timezone_set("Brazil/East");

        $ext      = strtolower(substr($img_name, -4));
        $new_name = date("Y.m.d-H.i.s") . $ext;

        move_uploaded_file($img_temp, $this->dir . $new_name);

        $caminho = $this->dir . $new_name;

        return $caminho;
    }

}
