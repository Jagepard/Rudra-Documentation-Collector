## Table of contents
- [D\Commands\ConsoleCommand](#d_commands_consolecommand)
- [D\Commands\DocumentationCommand](#d_commands_documentationcommand)
<hr>

<a id="d_commands_consolecommand"></a>

### Class: D\Commands\ConsoleCommand
| Visibility | Function |
|:-----------|:---------|
|public|actionIndex()<br><br>|
|protected|getTable( array $data )<br><br>|


<a id="d_commands_documentationcommand"></a>

### Class: D\Commands\DocumentationCommand
| Visibility | Function |
|:-----------|:---------|
|public|actionIndex()<br><br>/**<br>     * Undocumented function<br>     *<br>     * @return void<br>     */|
|protected|collectMarkdown( string $outputPath ): void<br><br>/**<br>     * Undocumented function<br>     *<br>     * @param  string $outputPath<br>     * @return void<br>     */|
|protected|scandir(  $inputPath   $outputPath )<br><br>/**<br>     * Undocumented function<br>     *<br>     * @param  [type] $inputPath<br>     * @param  [type] $outputPath<br>     * @return void<br>     */|
|protected|buildDocumentation(  $outputPath   $fullClassName )<br><br>/**<br>     * Undocumented function<br>     *<br>     * @param  [type] $outputPath<br>     * @param  [type] $fullClassName<br>     * @return void<br>     */|
|protected|setHeader( string $fullClassName ): void<br><br>/**<br>     * Undocumented function<br>     *<br>     * @param  string $fullClassName<br>     * @return void<br>     */|
|private|createHeaderString( string $fullClassName ): string<br><br>/**<br>     * Undocumented function<br>     *<br>     * @param  string $fullClassName<br>     * @return string<br>     */|
|protected|setBody(  $fullClassName ): void<br><br>/**<br>     * Undocumented function<br>     *<br>     * @param  [type] $fullClassName<br>     * @return void<br>     */|
|private|createBodyString( string $fullClassName ): string<br><br>/**<br>     * Undocumented function<br>     *<br>     * @param  string $fullClassName<br>     * @return string<br>     */|
<hr>