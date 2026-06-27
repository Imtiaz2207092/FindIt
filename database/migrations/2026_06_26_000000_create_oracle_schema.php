<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateOracleSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // users
        DB::unprepared(<<<'SQL'
CREATE SEQUENCE users_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE TABLE users (
    id NUMBER(20) PRIMARY KEY,
    name VARCHAR2(100),
    email VARCHAR2(100) UNIQUE,
    password VARCHAR2(255),
    phone VARCHAR2(20),
    role VARCHAR2(20) DEFAULT 'User',
    remember_token VARCHAR2(100),
    created_at TIMESTAMP
);
CREATE OR REPLACE TRIGGER users_bi
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
    IF :NEW.id IS NULL THEN
        SELECT users_seq.NEXTVAL INTO :NEW.id FROM DUAL;
    END IF;
END;
SQL
        );

        // admins
        DB::unprepared(<<<'SQL'
CREATE SEQUENCE admins_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE TABLE admins (
    admin_id NUMBER(20) PRIMARY KEY,
    name VARCHAR2(100),
    email VARCHAR2(100) UNIQUE,
    password VARCHAR2(255)
);
CREATE OR REPLACE TRIGGER admins_bi
BEFORE INSERT ON admins
FOR EACH ROW
BEGIN
    IF :NEW.admin_id IS NULL THEN
        SELECT admins_seq.NEXTVAL INTO :NEW.admin_id FROM DUAL;
    END IF;
END;
SQL
        );

        // categories
        DB::unprepared(<<<'SQL'
CREATE SEQUENCE categories_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE TABLE categories (
    category_id NUMBER(20) PRIMARY KEY,
    category_name VARCHAR2(50)
);
CREATE OR REPLACE TRIGGER categories_bi
BEFORE INSERT ON categories
FOR EACH ROW
BEGIN
    IF :NEW.category_id IS NULL THEN
        SELECT categories_seq.NEXTVAL INTO :NEW.category_id FROM DUAL;
    END IF;
END;
SQL
        );

        // lost_items
        DB::unprepared(<<<'SQL'
CREATE SEQUENCE lost_items_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE TABLE lost_items (
    lost_id NUMBER(20) PRIMARY KEY,
    user_id NUMBER(20),
    category_id NUMBER(20),
    title VARCHAR2(100),
    description VARCHAR2(4000),
    image VARCHAR2(255),
    location VARCHAR2(100),
    lost_date DATE,
    status VARCHAR2(50) DEFAULT 'Lost'
);
ALTER TABLE lost_items ADD CONSTRAINT fk_lost_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;
ALTER TABLE lost_items ADD CONSTRAINT fk_lost_category FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL;
CREATE OR REPLACE TRIGGER lost_items_bi
BEFORE INSERT ON lost_items
FOR EACH ROW
BEGIN
    IF :NEW.lost_id IS NULL THEN
        SELECT lost_items_seq.NEXTVAL INTO :NEW.lost_id FROM DUAL;
    END IF;
END;
SQL
        );

        // found_items
        DB::unprepared(<<<'SQL'
CREATE SEQUENCE found_items_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE TABLE found_items (
    found_id NUMBER(20) PRIMARY KEY,
    user_id NUMBER(20),
    category_id NUMBER(20),
    title VARCHAR2(100),
    description VARCHAR2(4000),
    image VARCHAR2(255),
    location VARCHAR2(100),
    found_date DATE,
    status VARCHAR2(50) DEFAULT 'Found'
);
ALTER TABLE found_items ADD CONSTRAINT fk_found_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;
ALTER TABLE found_items ADD CONSTRAINT fk_found_category FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL;
CREATE OR REPLACE TRIGGER found_items_bi
BEFORE INSERT ON found_items
FOR EACH ROW
BEGIN
    IF :NEW.found_id IS NULL THEN
        SELECT found_items_seq.NEXTVAL INTO :NEW.found_id FROM DUAL;
    END IF;
END;
SQL
        );

        // claims
        DB::unprepared(<<<'SQL'
CREATE SEQUENCE claims_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE TABLE claims (
    claim_id NUMBER(20) PRIMARY KEY,
    user_id NUMBER(20),
    lost_id NUMBER(20),
    found_id NUMBER(20),
    proof_details VARCHAR2(4000),
    status VARCHAR2(50) DEFAULT 'Pending',
    claim_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE claims ADD CONSTRAINT fk_claim_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;
ALTER TABLE claims ADD CONSTRAINT fk_claim_lost FOREIGN KEY (lost_id) REFERENCES lost_items(lost_id) ON DELETE SET NULL;
ALTER TABLE claims ADD CONSTRAINT fk_claim_found FOREIGN KEY (found_id) REFERENCES found_items(found_id) ON DELETE SET NULL;
CREATE OR REPLACE TRIGGER claims_bi
BEFORE INSERT ON claims
FOR EACH ROW
BEGIN
    IF :NEW.claim_id IS NULL THEN
        SELECT claims_seq.NEXTVAL INTO :NEW.claim_id FROM DUAL;
    END IF;
END;
SQL
        );

        // notifications
        DB::unprepared(<<<'SQL'
CREATE SEQUENCE notifications_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;
CREATE TABLE notifications (
    notification_id NUMBER(20) PRIMARY KEY,
    user_id NUMBER(20),
    message VARCHAR2(4000),
    status VARCHAR2(20) DEFAULT 'Unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE notifications ADD CONSTRAINT fk_notification_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;
CREATE OR REPLACE TRIGGER notifications_bi
BEFORE INSERT ON notifications
FOR EACH ROW
BEGIN
    IF :NEW.notification_id IS NULL THEN
        SELECT notifications_seq.NEXTVAL INTO :NEW.notification_id FROM DUAL;
    END IF;
END;
SQL
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop in reverse order to avoid FK conflicts
        DB::unprepared(<<<'SQL'
DROP TRIGGER notifications_bi;
DROP TABLE notifications CASCADE CONSTRAINTS;
DROP SEQUENCE notifications_seq;

DROP TRIGGER claims_bi;
DROP TABLE claims CASCADE CONSTRAINTS;
DROP SEQUENCE claims_seq;

DROP TRIGGER found_items_bi;
DROP TABLE found_items CASCADE CONSTRAINTS;
DROP SEQUENCE found_items_seq;

DROP TRIGGER lost_items_bi;
DROP TABLE lost_items CASCADE CONSTRAINTS;
DROP SEQUENCE lost_items_seq;

DROP TRIGGER categories_bi;
DROP TABLE categories CASCADE CONSTRAINTS;
DROP SEQUENCE categories_seq;

DROP TRIGGER admins_bi;
DROP TABLE admins CASCADE CONSTRAINTS;
DROP SEQUENCE admins_seq;

DROP TRIGGER users_bi;
DROP TABLE users CASCADE CONSTRAINTS;
DROP SEQUENCE users_seq;
SQL
        );
    }
}
