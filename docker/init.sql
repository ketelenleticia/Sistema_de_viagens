USE sistema_viagens;

CREATE TABLE IF NOT EXISTS tabela_clientes (
    id_cliente INT(11) AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cpf VARCHAR(100) NOT NULL,
    telefone VARCHAR(100) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS tabela_login (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS tabela_pacotes (
    id_pacote INT(11) AUTO_INCREMENT PRIMARY KEY,
    imagem VARCHAR(255),
    destino VARCHAR(150),
    descricao TEXT,
    preco DECIMAL(10,2),
    duracao INT,
    data_saida DATE
);

CREATE TABLE IF NOT EXISTS tabela_reservas (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    cliente INT NOT NULL,
    pacote INT NOT NULL,
    data_reserva DATE NOT NULL,
    data_viagem DATE NOT NULL,
    status VARCHAR(50) NOT NULL,

    FOREIGN KEY (cliente) REFERENCES tabela_clientes(id_cliente),
    FOREIGN KEY (pacote) REFERENCES tabela_pacotes(id_pacote)
);