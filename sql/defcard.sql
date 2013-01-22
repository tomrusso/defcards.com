CREATE TABLE cards
(
	public_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	private_id CHAR(9) UNIQUE NOT NULL,

	PRIMARY KEY(public_id),
	INDEX(private_id)
);

CREATE TABLE events
(
	event_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	type TINYINT UNSIGNED NOT NULL,
	card_id_ref INTEGER UNSIGNED NOT NULL,
	user_id_ref INTEGER UNSIGNED,
	time TIMESTAMP NOT NULL,
	body VARCHAR(1024),

	PRIMARY KEY(event_id),
	INDEX(type),
	INDEX(card_id_ref),
	INDEX(user_id_ref)
);

CREATE TABLE users
(
	user_id INTEGER UNSIGNED NOT NULL,
	name VARCHAR(100) NOT NULL,

	PRIMARY KEY(user_id)
);