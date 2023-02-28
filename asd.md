## Table of contents
- [Rudra\Validation\Validation](#rudra_validation_validation)
- [Rudra\Validation\ValidationFacade](#rudra_validation_validationfacade)
- [Rudra\Validation\ValidationInterface](#rudra_validation_validationinterface)
<hr>

<a id="rudra_validation_validation"></a>

### Class: Rudra\Validation\Validation
| Visibility | Function |
|:-----------|:---------|
|public|<em><strong>run</strong>(): array</em><br>Выдает массив с результатом проверки<br>в случае успешной проверки:<br>[$this>verifiable // проверенные данные, null // вместо сообщения об ошибке]<br>в случае если данные не соответствуют требованиям<br>[false // вместо проверенных данных, $this>message // сообщение о несоответствии]<br>Gives an array with the result of the check<br>in case of successful check:<br>[$this>verifiable // verified data, null instead of error message]<br>in case the data does not meet the requirements<br>[false // instead of validated data, $this>message // mismatch message]|
|public|<em><strong>approve</strong>( array $data ): bool</em><br>Checks if all elements of an array are validated<br>Array example:<br>$processed = [<br> 'csrf_field' => Validation::sanitize($inputData["csrf_field"])>csrf(Session::get("csrf_token"))>run(),<br> 'search' => Validation::sanitize($inputData["search"])>min(1)>max(50)>run(),<br> 'redirect' => Validation::sanitize($inputData["redirect"])>max(500)>run(),<br>];<br>Проверяет все ли элементы массива прошли проверку|
|public|<em><strong>getValidated</strong>( array $data  array $excludedKeys ): array</em><br>Get an array of validated data<br>$excludedKeys allows you to exclude elements which are not required after verification<br>example: Validation::getValidated($processed, ["csrf_field", "_method"]);<br>Получить массив данных прошедших проверку<br>$excludedKeys позволяет исключить элементы, которые не требуются после проверки|
|public|<em><strong>getAlerts</strong>( array $data  array $excludedKeys ): array</em><br>Receives messages about noncompliance with validation requirements<br>$excludedKeys allows you to exclude elements which are not required after verification<br>example: Validation::getAlerts($processed, ["_method"]);<br>Получает сообщения о несоответствии требованиям валидации<br>$excludedKeys позволяет исключить элементы, которые не требуются после проверки|
|private|<em><strong>removeExcluded</strong>( array $inputArray  array $excludedKeys )</em><br>Removes $excludedKeys from the array<br>Удаляет $excludedKeys исключенные ключи из массива|
|public|<em><strong>set</strong>(  $verifiable ): Rudra\Validation\ValidationInterface</em><br>Sets the data to be checked without processing<br>Устанавливает проверяемые данные без обработки|
|public|<em><strong>sanitize</strong>( string $verifiable  array|string|null $allowableTags ): Rudra\Validation\ValidationInterface</em><br>Sets the data to be checked with processing for strings <br>with valid tags: $allowableTags<br>Устанавливает проверяемые данные с обработкой для строк <br>с указанием допустимых тегов: $allowableTags|
|public|<em><strong>email</strong>( string $verifiable  string $message ): Rudra\Validation\ValidationInterface</em><br>Sets the data before checking that the value is a valid email.<br>Sets the status to false and an error message if validation fails<br>Устанавливает данные предварительно проверяя, что значение является корректным email<br>Устанавливает статус false и сообщение об ошибке, если проверка не пройдена|
|public|<em><strong>required</strong>( string $message ): Rudra\Validation\ValidationInterface</em><br>Checks if a string value is set in $this>verifiable<br>Проверяет установлено ли строковое значение в $this>verifiable|
|public|<em><strong>integer</strong>( string $message ): Rudra\Validation\ValidationInterface</em><br>Finds whether a $this>verifiable is a number or a numeric string <br>Проверяет, является ли $this>verifiable числом или строкой, содержащей число|
|public|<em><strong>min</strong>(  $length  string $message ): Rudra\Validation\ValidationInterface</em><br>Checks the string value in $this>verifiable against the minimum allowed number of characters<br>Проверяет строковое значение в $this>verifiable на минимально допустимое количество символов|
|public|<em><strong>max</strong>(  $length  string $message ): Rudra\Validation\ValidationInterface</em><br>Checks the string value in $this>verifiable against the maximum allowed number of characters<br>Проверяет строковое значение в $this>verifiable на максимально допустимое количество символов|
|public|<em><strong>equals</strong>(  $verifiable  string $message ): Rudra\Validation\ValidationInterface</em><br>Compares the equivalence of $verifiable and $this>verifiable values<br>Сравнивает эквивалентность значений $verifiable и $this>verifiable|
|public|<em><strong>csrf</strong>( array $csrfSession   $message ): Rudra\Validation\ValidationInterface</em><br>CrossSite Request Forgery Protection<br>Защита от межсайтовой подделки запроса|
|private|<em><strong>validate</strong>( bool $bool  string $message ): Rudra\Validation\ValidationInterface</em><br>Set status and error message if validation fails<br>Устанавливает статус и сообщение об ошибке, если проверка не пройдена|


<a id="rudra_validation_validationfacade"></a>

### Class: Rudra\Validation\ValidationFacade
| Visibility | Function |
|:-----------|:---------|
|public static|<em><strong>__callStatic</strong>(  $method   $parameters )</em><br>|


<a id="rudra_validation_validationinterface"></a>

### Class: Rudra\Validation\ValidationInterface
| Visibility | Function |
|:-----------|:---------|
|abstract public|<em><strong>run</strong>(): array</em><br>Выдает массив с результатом проверки<br>в случае успешной проверки:<br>[$this>verifiable // проверенные данные, null // вместо сообщения об ошибке]<br>в случае если данные не соответствуют требованиям<br>[false // вместо проверенных данных, $this>message // сообщение о несоответствии]<br>Gives an array with the result of the check<br>in case of successful check:<br>[$this>verifiable // verified data, null instead of error message]<br>in case the data does not meet the requirements<br>[false // instead of validated data, $this>message // mismatch message]|
|abstract public|<em><strong>approve</strong>( array $data ): bool</em><br>Checks if all elements of an array are validated<br>Array example:<br>$processed = [<br> 'csrf_field' => Validation::sanitize($inputData["csrf_field"])>csrf(Session::get("csrf_token"))>run(),<br> 'search' => Validation::sanitize($inputData["search"])>min(1)>max(50)>run(),<br> 'redirect' => Validation::sanitize($inputData["redirect"])>max(500)>run(),<br>];<br>Проверяет все ли элементы массива прошли проверку|
|abstract public|<em><strong>getValidated</strong>( array $data  array $excludedKeys ): array</em><br>Get an array of validated data<br>$excludedKeys allows you to exclude elements which are not required after verification<br>example: Validation::getValidated($processed, ["csrf_field", "_method"]);<br>Получить массив данных прошедших проверку<br>$excludedKeys позволяет исключить элементы, которые не требуются после проверки|
|abstract public|<em><strong>getAlerts</strong>( array $data  array $excludedKeys ): array</em><br>Receives messages about noncompliance with validation requirements<br>$excludedKeys allows you to exclude elements which are not required after verification<br>example: Validation::getAlerts($processed, ["_method"]);<br>Получает сообщения о несоответствии требованиям валидации<br>$excludedKeys позволяет исключить элементы, которые не требуются после проверки|
|abstract public|<em><strong>set</strong>(  $data ): Rudra\Validation\ValidationInterface</em><br>Sets the data to be checked without processing<br>Устанавливает проверяемые данные без обработки|
|abstract public|<em><strong>sanitize</strong>( string $verifiable  array|string|null $allowableTags ): Rudra\Validation\ValidationInterface</em><br>Sets the data to be checked with processing for strings <br>with valid tags: $allowableTags<br>Устанавливает проверяемые данные с обработкой для строк <br>с указанием допустимых тегов: $allowableTags|
|abstract public|<em><strong>email</strong>( string $data  string $message ): Rudra\Validation\ValidationInterface</em><br>Sets the data before checking that the value is a valid email.<br>Sets the status to false and an error message if validation fails<br>Устанавливает данные предварительно проверяя, что значение является корректным email<br>Устанавливает статус false и сообщение об ошибке, если проверка не пройдена|
|abstract public|<em><strong>required</strong>( string $message ): Rudra\Validation\ValidationInterface</em><br>Checks if a string value is set in $this>verifiable<br>Проверяет установлено ли строковое значение в $this>verifiable|
|abstract public|<em><strong>integer</strong>( string $message ): Rudra\Validation\ValidationInterface</em><br>Finds whether a $this>verifiable is a number or a numeric string <br>Проверяет, является ли $this>verifiable числом или строкой, содержащей число|
|abstract public|<em><strong>min</strong>(  $length  string $message ): Rudra\Validation\ValidationInterface</em><br>Checks the string value in $this>verifiable against the minimum allowed number of characters<br>Проверяет строковое значение в $this>verifiable на минимально допустимое количество символов|
|abstract public|<em><strong>max</strong>(  $length  string $message ): Rudra\Validation\ValidationInterface</em><br>Checks the string value in $this>verifiable against the maximum allowed number of characters<br>Проверяет строковое значение в $this>verifiable на максимально допустимое количество символов|
|abstract public|<em><strong>equals</strong>(  $data  string $message ): Rudra\Validation\ValidationInterface</em><br>Compares the equivalence of $verifiable and $this>verifiable values<br>Сравнивает эквивалентность значений $verifiable и $this>verifiable|
|abstract public|<em><strong>csrf</strong>( array $csrfSession   $message ): Rudra\Validation\ValidationInterface</em><br>CrossSite Request Forgery Protection<br>Защита от межсайтовой подделки запроса|
<hr>