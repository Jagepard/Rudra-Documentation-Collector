## Table of contents
- [Rudra\Markdown\Commands\ConsoleCommand](#rudra_markdown_commands_consolecommand)
- [Rudra\Markdown\Commands\DocumentationCommand](#rudra_markdown_commands_documentationcommand)
- [Rudra\Markdown\Creators\DocumentationCreatorInterface](#rudra_markdown_creators_documentationcreatorinterface)
- [Rudra\Markdown\Creators\HtmlCreator](#rudra_markdown_creators_htmlcreator)
- [Rudra\Markdown\Creators\MarkdownCreator](#rudra_markdown_creators_markdowncreator)
<hr>

<a id="rudra_markdown_commands_consolecommand"></a>

### Class: Rudra\Markdown\Commands\ConsoleCommand
| Visibility | Function |
|:-----------|:---------|
|public|<em><strong>actionIndex</strong>()</em><br>|
|protected|<em><strong>getTable</strong>( array $data )</em><br>|


<a id="rudra_markdown_commands_documentationcommand"></a>

### Class: Rudra\Markdown\Commands\DocumentationCommand
| Visibility | Function |
|:-----------|:---------|
|public|<em><strong>actionIndex</strong>(): void</em><br>|
|protected|<em><strong>scandir</strong>( string $inputPath  string $outputPath ): void</em><br>|
|protected|<em><strong>setData</strong>( string $fullClassName  string $type ): void</em><br>|


<a id="rudra_markdown_creators_documentationcreatorinterface"></a>

### Class: Rudra\Markdown\Creators\DocumentationCreatorInterface
| Visibility | Function |
|:-----------|:---------|
|abstract public|<em><strong>createDocs</strong>( string $outputPath ): void</em><br>|
|abstract public|<em><strong>createHeaderString</strong>( string $fullClassName ): string</em><br>|
|abstract public|<em><strong>createBodyString</strong>( string $fullClassName ): string</em><br>|


<a id="rudra_markdown_creators_htmlcreator"></a>

### Class: Rudra\Markdown\Creators\HtmlCreator
##### implements [Rudra\Markdown\Creators\DocumentationCreatorInterface](#rudra_markdown_creators_documentationcreatorinterface)
| Visibility | Function |
|:-----------|:---------|
|public|<em><strong>__construct</strong>( string $frameworkType )</em><br>|
|public|<em><strong>createDocs</strong>( string $outputPath ): void</em><br>|
|public|<em><strong>createHeaderString</strong>( string $fullClassName ): string</em><br>|
|public|<em><strong>createBodyString</strong>( string $fullClassName ): string</em><br>|
|private|<em><strong>getAnchorName</strong>(  $className ): string</em><br>|
|protected|<em><strong>setHtmlHeader</strong>(): string</em><br>|
|protected|<em><strong>setHtmlFooter</strong>(): string</em><br>|
|protected|<em><strong>setTableClass</strong>(): string</em><br>|


<a id="rudra_markdown_creators_markdowncreator"></a>

### Class: Rudra\Markdown\Creators\MarkdownCreator
##### implements [Rudra\Markdown\Creators\DocumentationCreatorInterface](#rudra_markdown_creators_documentationcreatorinterface)
| Visibility | Function |
|:-----------|:---------|
|public|<em><strong>createDocs</strong>( string $outputPath ): void</em><br>|
|public|<em><strong>createHeaderString</strong>( string $fullClassName ): string</em><br>|
|public|<em><strong>createBodyString</strong>( string $fullClassName ): string</em><br>|
|private|<em><strong>getAnchorName</strong>(  $className ): string</em><br>|
<hr>

###### created with [Rudra-Documentation-Collector](#https://github.com/Jagepard/Rudra-Documentation-Collector)
