# graphql-poc

# Example CURL request
```
curl --location --request POST 'http://localhost:8086/' \
--header 'Content-Type: text/plain' \
--data-raw '{"query":"query{\n    customer(id: 3) {\n        id,\n        firstname\n    }\n}","variables":{}}'
```
