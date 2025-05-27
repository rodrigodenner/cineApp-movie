<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API de Filmes",
 *     description="Documentação da API de filmes com integração à TMDB",
 *     @OA\Contact(
 *         name="Rodrigo Denner",
 *         email="rodrigodennerdev@gmail.com"
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="Bearer",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class SwaggerController {}
