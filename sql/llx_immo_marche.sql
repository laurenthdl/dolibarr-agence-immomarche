-- Module immomarche (700007) - Etude de marche
-- Ventes comparables
CREATE TABLE IF NOT EXISTS llx_immo_vente_comp (
    rowid serial PRIMARY KEY,
    ref varchar(30) NOT NULL UNIQUE,
    entity integer DEFAULT 1,
    quartier varchar(255),
    ville varchar(255),
    type_bien varchar(50), -- appartement, maison, terrain
    surface real,
    nb_pieces integer,
    prix_vente real,
    prix_m2 real,
    date_transaction date,
    source varchar(255), -- site, notaire, etc.
    fk_user_creat integer,
    fk_user_modif integer,
    tms timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    date_creation datetime DEFAULT CURRENT_TIMESTAMP
);

-- Locations comparables
CREATE TABLE IF NOT EXISTS llx_immo_location_comp (
    rowid serial PRIMARY KEY,
    ref varchar(30) NOT NULL UNIQUE,
    entity integer DEFAULT 1,
    quartier varchar(255),
    ville varchar(255),
    type_bien varchar(50),
    surface real,
    nb_pieces integer,
    loyer_mensuel real,
    charges_mensuelles real,
    loyer_m2 real,
    date_mise_location date,
    source varchar(255),
    fk_user_creat integer,
    fk_user_modif integer,
    tms timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    date_creation datetime DEFAULT CURRENT_TIMESTAMP
);
