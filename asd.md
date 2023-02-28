## Table of contents
- [Rudra\Cli\Console](#rudra_cli_console)
- [Rudra\Cli\ConsoleFacade](#rudra_cli_consolefacade)
- [Rudra\Cli\ConsoleInterface](#rudra_cli_consoleinterface)
<hr><br><a id="rudra_cli_console"></a><br>### Class: Rudra\Cli\Console
| Visibility | Function |
|:-----------|:---------|
|public|printer( string $text  string $fg  string $bg )|
|public|reader()|
|public|addCommand(  $name   $command )|
|public|invoke(  $inputArgs )|
|public|getRegistry()|
|private|checkColorExists( string $key )|
<br><a id="rudra_cli_consolefacade"></a><br>### Class: Rudra\Cli\ConsoleFacade
| Visibility | Function |
|:-----------|:---------|
|public static|__callStatic(  $method   $parameters )|
<br><a id="rudra_cli_consoleinterface"></a><br>### Class: Rudra\Cli\ConsoleInterface
| Visibility | Function |
|:-----------|:---------|
|abstract public|printer( string $text  string $fg  string $bg )|
|abstract public|reader()|
|abstract public|addCommand(  $name   $command )|
|abstract public|invoke(  $inputArgs )|
|abstract public|getRegistry()|
<hr>