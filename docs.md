## Table of contents
- [Rudra\Markdown\Command\Help](#rudra_markdown_command_help)
- [Rudra\Markdown\Command\MakeDocumentation](#rudra_markdown_command_makedocumentation)
- [Rudra\Markdown\Creators\DocumentationCreatorInterface](#rudra_markdown_creators_documentationcreatorinterface)
- [Rudra\Markdown\Creators\HtmlCreator](#rudra_markdown_creators_htmlcreator)
- [Rudra\Markdown\Creators\MarkdownCreator](#rudra_markdown_creators_markdowncreator)
<hr>

<a id="rudra_markdown_command_help"></a>

### Class: Rudra\Markdown\Command\Help
| Visibility | Function |
|:-----------|:---------|
| public | `actionIndex(): void`<br> |
| protected | `getTable(array $data, string $mask): void`<br> |


<a id="rudra_markdown_command_makedocumentation"></a>

### Class: Rudra\Markdown\Command\MakeDocumentation
| Visibility | Function |
|:-----------|:---------|
| public | `actionIndex(): void`<br> |
| private | `scandir(string $inputPath, string $outputPath): void`<br>Recursively scans a directory for PHP classes and processes files with uppercase filenames. |
| private | `setData(string $fullClassName, string $type): void`<br>Generates and appends documentation content for a class based on the specified type. |


<a id="rudra_markdown_creators_documentationcreatorinterface"></a>

### Class: Rudra\Markdown\Creators\DocumentationCreatorInterface
| Visibility | Function |
|:-----------|:---------|
| abstract public | `createDocs(string $outputPath): void`<br> |
| abstract public | `createHeaderString(string $fullClassName): string`<br> |
| abstract public | `createBodyString(string $fullClassName): string`<br> |


<a id="rudra_markdown_creators_htmlcreator"></a>

### Class: Rudra\Markdown\Creators\HtmlCreator
| Visibility | Function |
|:-----------|:---------|
| public | `__construct(string $frameworkType)`<br> |
| public | `createDocs(string $outputPath): void`<br> |
| public | `createHeaderString(string $fullClassName): string`<br> |
| public | `createBodyString(string $fullClassName): string`<br> |
| private | `getAnchorName(string $className): string`<br> |
| private | `setHtmlHeader(): string`<br> |
| private | `setHtmlFooter(): string`<br> |
| private | `setTableClass(): string`<br> |


<a id="rudra_markdown_creators_markdowncreator"></a>

### Class: Rudra\Markdown\Creators\MarkdownCreator
| Visibility | Function |
|:-----------|:---------|
| public | `createDocs(string $outputPath): void`<br> |
| public | `createHeaderString(string $fullClassName): string`<br> |
| public | `createBodyString(string $fullClassName): string`<br> |
| private | `buildMethodSignature(ReflectionMethod $method): string`<br>Builds the method signature with parameters and return type. |
| private | `extractDocBlockDescription(ReflectionMethod $method): string`<br> |
| private | `getParameterTypeAndName(ReflectionParameter $param): string`<br> |
| private | `getTypeAsString(ReflectionType $type): string`<br>Converts a ReflectionType to a string representation. |
| private | `getAnchorName(string $className): string`<br> |
<hr>

###### created with [Rudra-Documentation-Collector](#https://github.com/Jagepard/Rudra-Documentation-Collector)
