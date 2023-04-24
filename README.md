<div align="center">
    <h3>Api prueba técnica El Tiempo</h3>
</div>
<div>
<p align="center">
Código funcional de la prueba técnica para El Tiempo, en la cual se creo un endpoint para generar un JWT y 3 endpoint para consultar, crear y eliminar productos en la base de datos.
</p>
<ul>
<h4>Requerimientos en PC local:</h4>
<li>Tener instalado PHP8.1.</li>
<li>Tener instalado composer.</li>
<li>Tener instalado Symfony.</li>
<li>Tener instalado PostgreSQL 14.</li>
</ul>
<ol>
<h4>Pasos iniciar la aplicación:</h4>
<li>Descargar el proyecto del repositorio.</li>
<li>Ir a la carpeta raíz del proyecto desde la consola.</li>
<li>Ejecutar desde consola el comando <strong>"composer install"</strong> para instalar las dependencias de la aplicación.</li>
<li>Cambiar los datos de la conexión a la base de datos por los de la conexión local o remota en el archivo <strong>".env".</strong></li>
<li>Ejecutar el comando <strong>"symfony server:ca:install"</strong> para instalar un SSL en el servidor local de symfony.</li>
<li>Ejecutar el comando <strong>"symfony serve:start"</strong> para iniciar el servidor local de symfony.</li>
</ol>

<ul>
<h4>Funcionalidad:</h4>
<p>
Para consumir todos los endpoint habilitados en la aplicación (excepto el endpoint para generar el JWT) siempre se debe enviar un token de autorización (Authorization: Bearer) en el header de la petición para poder procesarla. Dicho token tiene una duración valida de 2 minutos.
</p>
<li>
<h4>Generar JWT</h4>
<p>
Url: <a href="https://localhost:8000/api/login_check">https://localhost:8000/api/login_check</a>
</br>Método: "GET"
</p>
<p>
JSON a enviar: 
{
    "username": "xxxxxxxxx",
    "password": "xxxxxxxxx"
}
</p>
<p>
JSON de respuesta: 
{
    "token": "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
}
</p>
</li>
<li>
<h4>Consultar listado de productos</h4>
<p>
Url: <a href="https://localhost:8000/api/v1/products?limit=5&offset=0">https://localhost:8000/api/v1/products?limit=5&offset=0</a>
</br>Método: "GET"
</p>
<p>
JSON de respuesta: 
{
    "total_items": 18,
    "total_pages": 18,
    "current_page": 1,
    "total_items_by_page": 5,
    "data": [
        {
            "id": 1,
            "name": "Magazine Futbolero",
            "ean13": "3216549870135",
            "reference": "HG25874136",
            "qty": 10,
            "active": true,
            "eliminate": false,
            "date_add": "23-04-2023 13:42",
            "categories": [
                {
                    "name": "Deportes",
                    "description": "ctividad o ejercicio físico, sujeto a determinadas normas, en que se hace prueba, con o sin competición, de habilidad, destreza o fuerza física.",
                    "short_description": "Recreación, pasatiempo o ejercicio físico, por lo común al aire libre."
                },
                {
                    "name": "Futbol",
                    "description": null,
                    "short_description": null
                }
            ]
        }
    ]
}
</p>
</li>

<li>
<h4>Crear un producto</h4>
<p>
Url: <a href="https://localhost:8000/api/v1/products">https://localhost:8000/api/v1/products</a>
</br>Método: "POST"
</p>
<p>
JSON a enviar: 
{
    "name": "Historieta condorito",
    "ean13": "3216549870156",
    "reference": "HYGTR45",
    "qty": 20
}
</p>
<p>
JSON de respuesta: 
{
    "msg": "Producto creado correctamente.",
    "data": {
        "id": 40,
        "name": "Historieta condorito",
        "ean13": "3216549870156",
        "reference": "HYGTR45",
        "qty": 20,
        "active": true,
        "eliminate": false,
        "date_add": "24-04-2023 10:25"
    }
}
</p>
</li>
<li>
<h4>Eliminar un producto</h4>
<p>
Url: <a href="https://localhost:8000/api/v1/products/{product_id}">https://localhost:8000/api/v1/products/{product_id}</a>
</br>Método: "DELETE"
</p>
<p>
JSON de respuesta: 
{
    "msg": "Producto eliminado correctamente."
}
</p>
</li>
</ul>
<ol>
<h4>Ejecutar prueba unitaria:</h4>
<p>
Se creo una prueba unitaria para verificar la generación del JWT de manera exitosa. Se valida el código HTTP de la respuesta de la petición y que en su cuerpo retorne un JSON con el atributo "token".
</p>
<li>Ir a la carpeta raíz del proyecto desde la consola.</li>
<li>Ejecutar desde consola el comando <strong>"./vendor/bin/phpunit"</strong>.</li>
<li>Verificar que en la pantalla de la consola no aparezcan errores y que al final se muestre el mensaje <strong>"OK, but there are issues! Tests: 1, Assertions: 2, Deprecations: 1"</strong>.</li>
</ol>
</div>