# Introduction

The dispatcher needs to track what aircrafts are used for which flight.

# Tasks
* Generate report file of flights grouped by aircraft in `HTML` format e.g.:
```html
<html>
<body>
<h3>Flights by aircraft</h3>
<ul>
    <li>L2T
        <ul>
            <li>X230 @ 2019-01-02 02:45:00</li>
            <li>E780 @ 2019-01-02 16:10:00</li>
        </ul>
    </li>
    <li>A40
        <ul>
            <li>Y560 @ 2019-01-02 12:00:00</li>
        </ul>
    </li>
</ul>
</body>
</html>
```
* Generate report in `JSON` format.
* Filter by date.
* Filter by aircraft.
* Print to screen or file.

# Usage

### Syntax

`php report.php [Arguments]...`

### Arguments

* `format` - specifies report format. Available formats: json, html. Defaults to json.
* `from` - filters flights from date. Format 'Y-m-d'.
* `to` - filters flights to date. Format 'Y-m-d'.
* `aircraft` - filters flights by aircraft iata code.  
* `output` - specifies report output. Available outputs: screen, file. Defaults to screen.
  
### Examples

* `php report.php` - will print json report to the screen with no filters applied.
* `php report.php format=html output=file aircraft=A40 from="2019-01-01" to="2020-01-01"` - will print html report to the file from 2019-01-01 to 2020-01-01 for A40 aircraft.