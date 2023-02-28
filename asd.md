## Table of contents
- [Rudra\Annotation\Annotation](#rudra_annotation_annotation)
- [Rudra\Annotation\AnnotationInterface](#rudra_annotation_annotationinterface)
- [Rudra\Annotation\AnnotationMatcher](#rudra_annotation_annotationmatcher)
<hr>

<a id="rudra_annotation_annotation"></a>

### Class: Rudra\Annotation\Annotation
| Visibility | Function |
|:-----------|:---------|
|public|<em>getAnnotations( string $className  ?string $methodName ): array</em><br>Get data from annotations<br>Получить данные из аннотаций|
|public|<em>getAttributes( string $className  ?string $methodName ): array</em><br>Get data from attributes (for php 8 and up)<br>Получить данные из атрибутов (для php 8 и выше)|
|private|<em>getReflection( string $className  ?string $methodName ): ReflectionClass|ReflectionMethod</em><br>Provides information about a method or class<br>Сообщает информацию о методе или классе|
|private|<em>parseAnnotations( string $docBlock ): array</em><br>Parses annotation data<br>Разбирает данные аннотаций|


<a id="rudra_annotation_annotationinterface"></a>

### Class: Rudra\Annotation\AnnotationInterface
| Visibility | Function |
|:-----------|:---------|
|abstract public|<em>getAnnotations( string $className  ?string $methodName ): array</em><br>Get data from annotations<br>Получить данные из аннотаций|
|abstract public|<em>getAttributes( string $className  ?string $methodName ): array</em><br>Get data from attributes (for php 8 and up)<br>Получить данные из атрибутов (для php 8 и выше)|


<a id="rudra_annotation_annotationmatcher"></a>

### Class: Rudra\Annotation\AnnotationMatcher
| Visibility | Function |
|:-----------|:---------|
|public|<em>getParams( array $exploded  string $assignment ): array</em><br>Parses parameters by key (assignment) value<br>and returns an array of parameters<br>Анализирует параметры по значению ключа (присваивания)<br>и возвращает массив параметров|
|private|<em>handleData( string $data  array $exploded ): ?array</em><br>Parses data into key => value pairs<br>Разбирает данные в пары ключ => значение|
<hr>