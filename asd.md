## Table of contents
- [Rudra\Annotation\Annotation](#rudra_annotation_annotation)
- [Rudra\Annotation\AnnotationInterface](#rudra_annotation_annotationinterface)
- [Rudra\Annotation\AnnotationMatcher](#rudra_annotation_annotationmatcher)
<hr>

<a id="rudra_annotation_annotation"></a>

### Class: Rudra\Annotation\Annotation
| Visibility | Function |
|:-----------|:---------|
|public|getAnnotations( string $className  ?string $methodName ): array<br>Get data from annotations
-------------------------
Получить данные из аннотаций|
|public|getAttributes( string $className  ?string $methodName ): array<br>Get data from attributes (for php 8 and up)
-------------------------------------------
Получить данные из атрибутов (для php 8 и выше)|
|private|getReflection( string $className  ?string $methodName ): ReflectionClass|ReflectionMethod<br>Provides information about a method or class
--------------------------------------------
Сообщает информацию о методе или классе|
|private|parseAnnotations( string $docBlock ): array<br>Parses annotation data
----------------------
Разбирает данные аннотаций|


<a id="rudra_annotation_annotationinterface"></a>

### Class: Rudra\Annotation\AnnotationInterface
| Visibility | Function |
|:-----------|:---------|
|abstract public|getAnnotations( string $className  ?string $methodName ): array<br>Get data from annotations
-------------------------
Получить данные из аннотаций|
|abstract public|getAttributes( string $className  ?string $methodName ): array<br>Get data from attributes (for php 8 and up)
-------------------------------------------
Получить данные из атрибутов (для php 8 и выше)|


<a id="rudra_annotation_annotationmatcher"></a>

### Class: Rudra\Annotation\AnnotationMatcher
| Visibility | Function |
|:-----------|:---------|
|public|getParams( array $exploded  string $assignment ): array<br>Parses parameters by key (assignment) value
and returns an array of parameters
----------------------------------
Анализирует параметры по значению ключа (присваивания)
и возвращает массив параметров|
|private|handleData( string $data  array $exploded ): ?array<br>Parses data into key => value pairs
-----------------------------------
Разбирает данные в пары ключ => значение|
<hr>