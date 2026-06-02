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
| private | `scandir(string $inputPath): void`<br>Recursively scans a directory for PHP classes,<br>interfaces, and traits, and accumulates documentation for them.<br>-----------------<br>Рекурсивно сканирует директорию в поисках PHP-классов,<br>интерфейсов и трейтов, и накапливает документацию по ним. |
| private | `setData(string $fullClassName, string $type): void`<br>Generates and appends documentation content for a class based on the specified type<br>------------------<br>Генерирует и добавляет контент документации для класса на основе указанного типа |


<a id="rudra_markdown_renderers_documentationrendererinterface"></a>

### Class: Rudra\Markdown\Renderers\DocumentationRendererInterface
| Visibility | Function |
|:-----------|:---------|
| abstract public | `renderDocs(string $outputPath): void`<br>Generates and saves the full documentation document<br>-------------------<br>Генерирует и сохраняет полный документ документации |
| abstract public | `renderHeader(string $fullClassName): string`<br>Generates the header part of the documentation for a class (for the table of contents)<br>------------------<br>Генерирует заголовочную часть документации для класса (для оглавления). |
| abstract public | `renderBody(string $fullClassName): string`<br>Generates the main part of the documentation for a class (methods table)<br>------------------<br>Генерирует основную часть документации для класса (таблица методов) |


<a id="rudra_markdown_renderers_htmlrenderer"></a>

### Class: Rudra\Markdown\Renderers\HtmlRenderer
| Visibility | Function |
|:-----------|:---------|
| public | `__construct(string $cssFramework)`<br>Sets the CSS framework for styling the generated HTML documentation<br>----------------------<br>Устанавливает CSS-фреймворк для оформления генерируемой HTML-документации. |
| public | `renderDocs(string $outputPath): void`<br>Generates and saves the full documentation document<br>-------------------<br>Генерирует и сохраняет полный документ документации |
| public | `renderHeader(string $fullClassName): string`<br>Generates the header part of the documentation for a class (for the table of contents)<br>------------------<br>Генерирует заголовочную часть документации для класса (для оглавления). |
| public | `renderBody(string $fullClassName): string`<br>Generates the main part of the documentation for a class (methods table)<br>------------------<br>Генерирует основную часть документации для класса (таблица методов) |
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
| public | `renderDocs(string $outputPath): void`<br> |
| public | `renderHeader(string $fullClassName): string`<br> |
| public | `renderBody(string $fullClassName): string`<br> |
| private | `buildMethodRow(ReflectionMethod $method): string`<br>Builds a row for a method in a Markdown table<br>-------------<br>Собирает одну строку Markdown-таблицы для метода класса |
| private | `getAnchorName(string $className): string`<br>Extracts the anchor name for a class<br>------------------<br>Преобразует полное имя класса в якорь для Markdown-ссылок |
| private | `buildMethodSignature(ReflectionMethod $method): string`<br>Builds the method signature with parameters and return type<br>------------------<br>Собирает сигнатуру метода с параметрами и типом возвращаемого значения |
| private | `extractDocBlock(ReflectionMethod $method): string`<br>Extracts and clears the description from a DocBlock method<br>Escapes \$ and \| for safe display inside a Markdown table<br>-------------------<br>Извлекает и очищает описание из DocBlock метода<br>Экранирует `$` и `|` для безопасного отображения внутри Markdown-таблицы |
| private | `getParameterTypeAndName(ReflectionParameter $param): string`<br>Formats a parameter's type and name<br>-------------------<br>Формирует строковое представление параметра метода (тип + имя) |
| private | `getTypeAsString(ReflectionType $type): string`<br>Converts a ReflectionType to a string representation<br>------------------<br>Преобразует ReflectionType в строковое представление |


---

###### created with [Rudra-Documentation-Collector](https://github.com/Jagepard/Rudra-Documentation-Collector)
