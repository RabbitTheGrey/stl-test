DO $$
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_roles WHERE rolname = 'admin') THEN
        CREATE USER admin WITH PASSWORD 'securepassw0rd!';
    END IF;
END
$$;

DO $$
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_database WHERE datname = 'stl') THEN
        CREATE DATABASE stl OWNER admin;
    END IF;
END
$$;

DO $$
GRANT ALL PRIVILEGES ON DATABASE stl TO admin;
$$;
