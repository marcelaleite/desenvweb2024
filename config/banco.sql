-- criar o banco e tabela
create database contatos;
use contatos;
create table pessoa (
    id int primary key auto_increment,
    nome varchar(250),
    telefone varchar(250)
);
-- inserir dados na tabela
insert into pessoa values (null, 'Marcela','124');
insert into pessoa values (null, 'Maria','222');
insert into pessoa values (null, 'Marta','333');
insert into pessoa values (null, 'João','444');

-- criar usuário para o banco
create user 'fulano'@'localhost' identified by '123'; -- cria o usuário para acessar ao banco de dados com o login fulano e senha 123
grant all on contatos.* to 'fulano'@'localhost'; -- dá todas as permissões para o usuário fulano no banco contatos

alter table pessoa
add column usuario varchar(250) unique,
add column senha varchar(250);


desc pessoa;
use contatos;
create table endereco(  idendereco int primary key auto_increment,
						cep varchar(100),
						pais varchar(100),
						estado varchar(2),
						cidade varchar(250),
						bairro varchar(250),
						rua varchar(250),
						numero int,
						complemento varchar(250),
                        idpessoa int,
                        foreign key fk_pessoa (idpessoa) 
                                       references pessoa(id) on delete cascade
					);







commit;