[![Maintainability](https://qlty.sh/badges/56f27365-53f0-418a-b43c-898517859599/maintainability.svg)](https://qlty.sh/gh/Jagepard/projects/Rudra-Documentation-Collector)
[![CodeFactor](https://www.codefactor.io/repository/github/jagepard/rudra-documentation-collector/badge)](https://www.codefactor.io/repository/github/jagepard/rudra-documentation-collector)

# Rudra-Documentation-Collector | [API](https://github.com/Jagepard/Rudra-Markdown/blob/master/docs.md "Documentation API")

## Install
```composer require rudra/docs```
### Generate docs for all classes in a source directory
```$ ./vendor/bin/rudra-docs```
### Add a command to Rudra Framework ```config/commands.yml```
```yml
make:docs:
  - Rudra\Markdown\Command\MakeDocumentation
```
### Specify the path of the required folder with classes
```Enter source directory: src``` or ```Enter source directory: vendor/rudra/cli```

### Specify the name of the output file .md
```Enter file name: api```
## License
This project is licensed under the **Mozilla Public License 2.0 (MPL-2.0)** — a free, open-source license that:

- Requires preservation of copyright and license notices,
- Allows commercial and non-commercial use,
- Requires that any modifications to the original files remain open under MPL-2.0,
- Permits combining with proprietary code in larger works.

📄 Full license text: [LICENSE](./LICENSE)  
🌐 Official MPL-2.0 page: https://mozilla.org/MPL/2.0/