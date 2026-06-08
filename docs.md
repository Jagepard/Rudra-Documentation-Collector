## Table of contents
- [Rudra\Markdown\Command\MakeDocumentation](#rudra_markdown_command_makedocumentation)
- [Rudra\Markdown\Renderers\DocumentationRendererInterface](#rudra_markdown_renderers_documentationrendererinterface)
- [Rudra\Markdown\Renderers\HtmlRenderer](#rudra_markdown_renderers_htmlrenderer)
- [Rudra\Markdown\Renderers\MarkdownRenderer](#rudra_markdown_renderers_markdownrenderer)


---



<a id="rudra_markdown_command_makedocumentation"></a>

### Class: Rudra\Markdown\Command\MakeDocumentation
| Visibility | Function |
|:-----------|:---------|
| public | `actionIndex(): void`<br> |
| private | `scandir(string $inputPath): void`<br>Recursively scans a directory for PHP classes,<br>interfaces, and traits, and accumulates documentation for them. |
| private | `setData(string $fullClassName, string $type): void`<br>Generates and appends documentation content for a class based on the specified type |


<a id="rudra_markdown_renderers_documentationrendererinterface"></a>

### Class: Rudra\Markdown\Renderers\DocumentationRendererInterface
| Visibility | Function |
|:-----------|:---------|
| abstract public | `renderDocs(string $outputPath): void`<br> |
| abstract public | `renderHeader(string $fullClassName): string`<br> |
| abstract public | `renderBody(string $fullClassName): string`<br> |


<a id="rudra_markdown_renderers_htmlrenderer"></a>

### Class: Rudra\Markdown\Renderers\HtmlRenderer
| Visibility | Function |
|:-----------|:---------|
| public | `__construct(string $cssFramework)`<br>Sets the CSS framework for styling the generated HTML documentation |
| public | `renderDocs(string $outputPath): void`<br>Generates and saves the full documentation document |
| public | `renderHeader(string $fullClassName): string`<br>Generates the header part of the documentation for a class (for the table of contents) |
| public | `renderBody(string $fullClassName): string`<br>Generates the main part of the documentation for a class (methods table) |
| private | `buildClassHeader(ReflectionClass $class, string $fullClassName): string`<br> |
| private | `buildMethodsTable(array $methods): string`<br> |
| private | `buildMethodRow(ReflectionMethod $method): string`<br> |
| private | `extractDocBlock(ReflectionMethod $method): string`<br> |
| private | `getAnchorName(string $className): string`<br> |
| private | `setHtmlHeader(): string`<br> |
| private | `setHtmlFooter(): string`<br> |
| private | `setTableClass(): string`<br> |


<a id="rudra_markdown_renderers_markdownrenderer"></a>

### Class: Rudra\Markdown\Renderers\MarkdownRenderer
| Visibility | Function |
|:-----------|:---------|
| public | `renderDocs(string $outputPath): void`<br>Generates and saves the full documentation document |
| public | `renderHeader(string $fullClassName): string`<br>Generates the header part of the documentation for a class (for the table of contents) |
| public | `renderBody(string $fullClassName): string`<br>Generates the main part of the documentation for a class (methods table) |
| private | `buildMethodRow(ReflectionMethod $method): string`<br> |
| private | `getAnchorName(string $className): string`<br> |
| private | `buildMethodSignature(ReflectionMethod $method): string`<br> |
| private | `extractDocBlock(ReflectionMethod $method): string`<br> |
| private | `getParameterTypeAndName(ReflectionParameter $param): string`<br> |
| private | `getTypeAsString(ReflectionType $type): string`<br> |


---

###### created with [Rudra-Documentation-Collector](https://github.com/Jagepard/Rudra-Documentation-Collector)
