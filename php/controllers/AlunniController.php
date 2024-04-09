<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  public function connectMySQL(){
    $connection = new mysqli("localhost", "root", "ciccio", "scuola");
    if($connection->connect_error){
        die($connection->connect_error);
    }
    return $connection;
  }

  public function index(Request $request, Response $response, $args){
    $connection = connectMySQL();
    $result = $connection->query("SELECT * FROM alunni");
    $results = $result->fetch_all(MYSQLI_ASSOC);
    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function getAlunno(Request $request, Response $response, $args){
    $connection = connectMySQL();
    $id = $args["id"];
    $result = $connection->query("SELECT * FROM alunni WHERE id = $id");
    $results = $result->fetch_all(MYSQLI_ASSOC);
    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function postAlunno(Request $request, Response $response, $args){
    $connection = connectMySQL();
    $data = json_decode($request->getBody()->getContents(), true);
    $nome = $data["nome"];
    $cognome = $data["cognome"];
    $connection->query("INSERT INTO alunni (nome, cognome) VALUES($nome, $cognome)");
    $response->getBody()->write(json_encode($data));
    return $response->withHeader("Content-Type", "application/json")->withStatus(200);
  }

  public function putAlunno(Request $request, Response $response, $args){

  }

  public function deleteAlunno(Request $request, Response $response, $args){

  }
}
