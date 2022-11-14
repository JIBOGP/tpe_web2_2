# Productos: http://localhost/proyects/tpe_web2_2/api/products

## GET api/products
### Devuelve todos los productos

### -Filtrar por cualquiera de los atributos (atributo es cualqueira de los atributos de la tabla)
#### Busca las filas de la columna "atributo" cuyo valor sea igual al de "valor"
    .../api/products?atributo=valor
#### Busca las filas de la columna "atributo" cuyo valor contenga la subcadena "valor"
##### //ignora si antes de "valor" hay algo
    .../api/products?atributo=%valor
##### //ignora si antes y despues de "valor" hay algo
    .../api/products?atributo=%valor%
##### //ignora si despues de "valor" hay algo
    .../api/products?atributo=valor%
#### Busca las filas de la columna "atributo" cuyo valor sea igual al de "valor" ignorando partes especificas
##### //ignora la primera letra y ve si lo que sigue de esta es igual a "valor"
    .../api/products?atributo=_valor
##### //ignora las primeras 2 letras
    .../api/products?atributo=__valor
##### //ignora la primera y ultima letra
    .../api/products?atributo=_valor_
##### //ignora la ultima letra
    .../api/products?atributo=valor_
##### //ignora la anteultima letra y termina en a
    .../api/products?atributo=valor_a

### -Ordenar por atributo (por defecto "id") 
##### // "atributo" es cualquiera de los atributos de la tabla
    .../api/products?sortby=atributo        
#### Ordenar de forma ascendente (por defecto)
    .../api/products?sortby=atributo&order=asc
#### Ordenar de forma descendente
    .../api/products?sortby=atributo&order=desc

## GET api/products/:ID

### Devuelve un producto por su id.
    .../api/products/465
    
## POST api/products
### Crea un nuevo producto
    .../api/products

## DELETE api/products/:ID
### Elimina un producto por su id
    .../api/products/123

## PUT api/products/:ID
### Edita la informacion de un producto por su id
    .../api/products/123

# Comentarios: http://localhost/proyects/tpe_web2_2/api/comments

## GET api/comments
### Devuelve todos los comentarios

### -Filtrar por cualquiera de los atributos (atributo es cualqueira de los atributos de la tabla)
#### Busca las filas de la columna "atributo" cuyo valor sea igual al de "valor"
    .../api/comments?atributo=valor
#### Busca las filas de la columna "atributo" cuyo valor contenga la subcadena "valor"
##### //ignora si antes de "valor" hay algo
    .../api/comments?atributo=%valor
##### //ignora si antes y despues de "valor" hay algo
    .../api/comments?atributo=%valor%
##### //ignora si despues de "valor" hay algo
    .../api/comments?atributo=valor%
#### Busca las filas de la columna "atributo" cuyo valor sea igual al de "valor" ignorando partes especificas
##### //ignora la primera letra y ve si lo que sigue de esta es igual a "valor"
    .../api/comments?atributo=_valor
##### //ignora las primeras 2 letras
    .../api/comments?atributo=__valor
##### //ignora la primera y ultima letra
    .../api/comments?atributo=_valor_
##### //ignora la ultima letra
    .../api/comments?atributo=valor_
##### //ignora la anteultima letra y termina en a
    .../api/comments?atributo=valor_a

### -Ordenar por atributo (por defecto "id") 
##### // "atributo" es cualquiera de los atributos de la tabla
    .../api/comments?sortby=atributo        
#### Ordenar de forma ascendente (por defecto)
    .../api/comments?sortby=atributo&order=asc
#### Ordenar de forma descendente
    .../api/comments?sortby=atributo&order=desc

## GET api/comments/:ID
### Devuelve un comentario por su id.
    .../api/comments/465
    
## POST api/comments
### Agrega un nuevo comentario
    .../api/comments

## DELETE api/comments/:ID
### Elimina un comentario por su id
    .../api/comments/123

## PUT api/comments/:ID
### Edita la informacion de un comentario por su id
    .../api/comments/123
    