CREATE TABLE IF NOT EXISTS llx_immo_marche_comparable (
    rowid SERIAL PRIMARY KEY,
    ref VARCHAR(128) NOT NULL UNIQUE,
    label VARCHAR(255),
    description TEXT,
    fk_user_creat INTEGER NOT NULL,
    datec TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tms TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status INTEGER NOT NULL DEFAULT 0
);
CREATE INDEX idx_immo_marche_comparable_ref ON llx_immo_marche_comparable(ref);
