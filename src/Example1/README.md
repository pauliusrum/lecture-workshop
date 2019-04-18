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