CREATE TABLE test_table (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100)
);

-- Insert some sample data
INSERT INTO test_table (name) VALUES ('John'), ('Jane'), ('Doe');