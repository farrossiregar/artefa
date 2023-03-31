# jquery-ui-timespinner

Time spinner using jquery-ui.

## Dependencies

* jquery-ui-dist
* moment

You should include these libraries before use.

## Usage

Create a spinner:

```javascript
$('input.spinner').timespinner();
```

Change time format to `HH:mm:ss`:

```javascript
$('input.spinner').timespinner({ format: 'HH:mm:ss', step: 1, page: 60 });
```

You can use `Hms` as the format.

* H: hours
* m: minutes
* s: seconds

## License

The library is available as open source under the terms of the [MIT License](http://opensource.org/licenses/MIT).
