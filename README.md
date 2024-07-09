Install
=======

Clone this repository

```bash
$ git clone git@github.com:adrienroches-sensio/sf7pack_2024.07.09.git
$ cd ./sf7pack_2024.07.09
```

Run the following commands :

```bash
$ symfony composer install
$ symfony console importmap:install
$ symfony console doctrine:database:create
```

Then start the server with :

```bash
$ symfony serve -d
```
