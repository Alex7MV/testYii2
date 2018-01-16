
-- id, сумма, валюта, email(направление перевода), дата и время операции сумма, валюта
--
create table currency_operation (
	id integer not null auto_increment,
	sum integer not null,
	currency varchar(20) not null,
	currency_from varchar(200) not null,

	inserted_datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	primary key(id)
);
