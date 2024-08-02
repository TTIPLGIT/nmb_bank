CREATE TABLE government_task_details (
    id INT NOT NULL,
    instruction_id INT,
    stakeholder_id INT,
    task_name VARCHAR(255),
    task_description TEXT,
    priority VARCHAR(50),
    status VARCHAR(50),
    created_at TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP NULL,
    updated_by INT NULL
);