-- Create the questions table
    CREATE TABLE questions (
        id INTEGER PRIMARY KEY,
        question_text TEXT NOT NULL
    );

    -- Create the answers table
    CREATE TABLE answers (
        id INTEGER PRIMARY KEY,
        question_id INTEGER NOT NULL,
        answer_text TEXT NOT NULL,
        is_correct BOOLEAN NOT NULL,
        FOREIGN KEY (question_id) REFERENCES questions(id)
    );

    -- Insert sample questions and answers
    INSERT INTO questions (question_text) VALUES
    ('What is the capital of France?'),
    ('What is the highest mountain in the world?'),
    ('Who painted the Mona Lisa?');

    INSERT INTO answers (question_id, answer_text, is_correct) VALUES
    (1, 'Berlin', 0),
    (1, 'Paris', 1),
    (1, 'Madrid', 0),
    (1, 'Rome', 0),
    (2, 'Mount Everest', 1),
    (2, 'K2', 0),
    (2, 'Kangchenjunga', 0),
    (2, 'Lhotse', 0),
    (3, 'Leonardo da Vinci', 1),
    (3, 'Michelangelo', 0),
    (3, 'Raphael', 0),
    (3, 'Donatello', 0);
