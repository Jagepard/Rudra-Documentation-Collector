## Table of contents
- [Rudra\Annotation\Annotation](#rudra_annotation_annotation)
- [Rudra\Annotation\AnnotationInterface](#rudra_annotation_annotationinterface)
- [Rudra\Annotation\AnnotationMatcher](#rudra_annotation_annotationmatcher)
<hr>

<a id="rudra_annotation_annotation"></a>

### Class: Rudra\Annotation\Annotation
| Visibility | Function |
|:-----------|:---------|
|public|getAnnotations( string $className  ?string $methodName )|
|public|getAttributes( string $className  ?string $methodName )|
|private|getReflection( string $className  ?string $methodName )|
|private|parseAnnotations( string $docBlock )|


<a id="rudra_annotation_annotationinterface"></a>

### Class: Rudra\Annotation\AnnotationInterface
| Visibility | Function |
|:-----------|:---------|
|abstract public|getAnnotations( string $className  ?string $methodName )|
|abstract public|getAttributes( string $className  ?string $methodName )|


<a id="rudra_annotation_annotationmatcher"></a>

### Class: Rudra\Annotation\AnnotationMatcher
| Visibility | Function |
|:-----------|:---------|
|public|getParams( array $exploded  string $assignment )|
|private|handleData( string $data  array $exploded )|
<hr>