- Ingresar directorio con el nombre del dominio a certificar (ej: www.example.com), el cual contendrá los archivos del certificado SSL
- Por defeco se espera la siguiente estructura:
```
certs
 ├── README.md
 └── (dominio)
      ├── cert1.pem
      ├── chain1.pem
      ├── fullchain1.pem
      └── privkey1.pem
```

`privkey.pem`  : the private key for your certificate.
`fullchain.pem`: the certificate file used in most server software.
`chain.pem`    : used for OCSP stapling in Nginx >=1.3.7.
`cert.pem`     : will break many server configurations, and should not be used
                 without reading further documentation.
