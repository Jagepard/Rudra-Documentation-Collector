## Table of contents
- [D\Commands\ConsoleCommand](#d_commands_consolecommand)
- [D\Commands\DocumentationCommand](#d_commands_documentationcommand)
<hr><a id="d_commands_consolecommand"></a>
### Class: D\Commands\ConsoleCommand
| Visibility | Function |
|:-----------|:---------|
|public|actionIndex()|
|protected|getTable( array $data )|
<a id="d_commands_documentationcommand"></a>
### Class: D\Commands\DocumentationCommand
| Visibility | Function |
|:-----------|:---------|
|public|actionIndex()|
|protected|collectMarkdown( string $outputPath )|
|protected|scandir(  $inputPath   $outputPath )|
|protected|buildDocumentation(  $outputPath   $fullClassName )|
|protected|setHeader( string $fullClassName )|
|private|createHeaderString( string $fullClassName )|
|protected|setBody(  $fullClassName )|
|private|createBodyString( string $fullClassName )|
<hr>