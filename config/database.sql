CREATE TABLE users (
    user_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(64),
    last_name VARCHAR(64) NOT NULL,
    login VARCHAR(32) NOT NULL,
    password VARCHAR(32) NOT NULL,
    email VARCHAR(128) NOT NULL UNIQUE,
    telephone VARCHAR(20)
);

    CREATE TABLE clients(
        client_id INTEGER PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        pseudo VARCHAR(31),
        FOREIGN KEY (user_id) REFERENCES users(user_id)
    );
    CREATE TABLE personal(
        personal_id INTEGER PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        matricule VARCHAR(31) NOT NULL,
        role VARCHAR(20) NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(user_id)
    );
    CREATE TABLE deliver(
        deliver_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    )

    CREATE INDEX idx_clients_username ON clients(user_name);
    CREATE INDEX idx_users_name ON users(first_name, last_name);

CREATE TABLE server(
    serveur_id  INTEGER PRIMARY KEY AUTO_INCREMENT,
    personal_id INT(20) NOT NULL,
    FOREIGN KEY (personal_id) REFERENCES personal(personal_id),
)