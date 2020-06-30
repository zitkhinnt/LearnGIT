<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\DomainException;
use DB;
use Modules\Horserace\Entities\User;

class JWTRepositories
{
  protected function jwt($input)
  {
    $payload = [
      'iss' => "1and0nly.jp",                             // Issuer of the token
      'sub' => $input["user"]->id,                                 // Subject of the token
      'iat' => time(),                                    // Time when JWT was issued.
      'exp' => time() + JWT_EXPIRATION,    // Expiration time
      'data' => [
        'trans_id' => $input["trans_id"],
        'id' => $input["user"]->id,
        'mail_pc' => $input["user"]->mail_pc,
        'login_id' => $input["user"]->login_id,
        'member_level' => $input["user"]->member_level,
        'point' => $input["point"],
        'price' => $input["price"],
        'method' => $input["method"],
        'option' => $input["option"],
      ]
    ];
    return JWT::encode($payload, JWT_SECRET, 'HS256');
  }

  public function jwtBank($input)
  {
    $payload = [
      'sub' => $input["user_id"],                                 // Subject of the token
      'iat' => time(),                                    // Time when JWT was issued.
      'exp' => time() + JWT_EXPIRATION,    // Expiration time
      'data' => [
        'trans_id' => $input["trans_id"],
        'price' => $input["price"],
        'point' => $input["point"],
      ]
    ];
    return JWT::encode($payload, JWT_SECRET, 'HS256');
  }

  public function createJWT($input)
  {
    // Point
    $data = [
      'point' => trim($input["point"]),
      'price' => trim($input["price"]),
      'method' => trim($input["method"]),
      'option' => trim($input["option"]),
      'trans_id' => trim($input["trans_id"]),
    ];

    // User
    $obj_user = new User();
    $user = $obj_user->getUserById(trim($input["user_id"]));
    $data["user"] = $user;

    $result = $this->jwt($data);
    return $result;
  }

  public function createJWTBank($input)
  {
    // Point
    $data = [
      'point' => trim($input["point"]),
      'price' => trim($input["price"]),
      'method' => trim($input["method"]),
      'option' => trim($input["option"]),
      'trans_id' => trim($input["trans_id"]),
      'user_id' => trim($input["user_id"]),
    ];

    $result = $this->jwtBank($data);
    return $result;
  }

  public function checkJWT($token)
  {
    $result = array();

    try {
      // Get data token
      $credentials = (array)JWT::decode($token, JWT_SECRET, ['HS256']);
      $result = [
        "status" => "SUCCESS",
        "message" => "Data success",
        "content" => $credentials,
      ];
    } catch (ExpiredException $e) {
      // Error expired
      $result = [
        "status" => "ERROR",
        "message" => "Provided token is expired.",
      ];
    } catch (SignatureInvalidException $e) {
      // Token wrong
      $result = [
        "status" => "ERROR",
        "message" => "Token signature is wrong.",
      ];
    } catch (DomainException $e) {
      // Token wrong
      $result = [
        "status" => "ERROR",
        "message" => "Token data is wrong.",
      ];
    } catch (Exception $e) {
      // Not decoding
      $result = [
        "status" => "ERROR",
        "message" => "An error while decoding token.",
      ];
    }

    return $result;
  }
}