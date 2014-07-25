DROP TABLE IF EXISTS task;
CREATE TABLE task(
    id BIGINT NOT NULL AUTO_INCREMENT,
    label TEXT,
    dateCreated TIMESTAMP NOT NULL DEFAULT now(),
    completed BOOLEAN NOT NULL DEFAULT FALSE,
    dateCompleted TIMESTAMP,
    priority INT,
    PRIMARY KEY(id)
);

INSERT INTO task (label, priority) VALUES
    ('Leave a note', 3),
    ('Make a huge mistake', 4),
    ('Search for loose seal', 1),
    ('Buy mustard and parmesan cheese', 5);

INSERT INTO task (label, priority, completed, dateCompleted) VALUES
    ('Take some chicken bones, throw it in a pot, add some broth, a potato and get a stew going', 2, TRUE, CURRENT_TIMESTAMP());
