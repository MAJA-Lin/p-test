# p-test

## How to Use

You can simply run with:

> docker-compose run php **function_name** ...args

The function_name are `ordinal`, `sunday`, and `obfuscate`.

### For *ordinal indicator suffix*, run:

```bash
docker-compose run php ordinal 102
# Output: 102nd
```

### *Calculate how many Sundays between two dates*, run:

```bash
docker-compose run php sunday 01-05-2021 30-05-2021
# Output: 5
```

### *Get obfuscated information*

```bash
docker-compose run php obfuscate "localpart@example.org"
# Output: l*******t@example.org

docker-compose run php obfuscate "998 123 456 789"
# Output: ***-***-**6-789

docker-compose run php obfuscate "+12 4455 6666 9989"
# Output: +**-****-****-9989
```

## Tests

For running the test, modify docker argument `TESTING` to true and run the following commands *[1]*:

```bash
docker-compose run --entrypoint '/usr/bin/composer' php test
```


*[1]*: For the Windows environment, change *overwrote entrypoint* argument to this:

```bash
docker-compose run --entrypoint '//usr/bin/composer' php test
```
