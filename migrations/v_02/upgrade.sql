CREATE TABLE users
(
    id uuid DEFAULT gen_random_uuid() NOT NULL
        CONSTRAINT id
        PRIMARY KEY,
    login VARCHAR NOT NULL
        CONSTRAINT users_pk
        UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);
