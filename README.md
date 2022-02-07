# p-test

## How to Use

Build environment with *docker*:

```bash
docker-compose up --build -d
```

For running the test, run the following commands:

```bash
docker-compose exec php bash
(inside container) composer test
```

