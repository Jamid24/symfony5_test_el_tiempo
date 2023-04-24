<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230424001302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creation tables product, category and category_by_product.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('create table if not exists public.product( product_id serial not null, name varchar(60) not null, ean13 varchar(13) not null, reference varchar(50), quantity int not null, is_active boolean not null DEFAULT true, is_eliminate boolean not null DEFAULT false, date_add timestamp without time zone not null default now(), date_upd timestamp without time zone not null default now(), constraint pk_product primary key (product_id), constraint uq_product_ean13 unique (ean13) );');
        $this->addSql('create table if not exists public.category( category_id serial not null, name varchar(60) not null, description varchar(255), short_description varchar(120), is_active boolean not null DEFAULT true, is_eliminate boolean not null DEFAULT false, date_add timestamp without time zone not null default now(), date_upd timestamp without time zone not null default now(), constraint pk_category primary key (category_id) );');
        $this->addSql('create table if not exists public.category_by_product( product_id int not null, category_id int not null, date_add timestamp without time zone not null default now(), constraint pk_category_by_product primary key (product_id, category_id), constraint fk_category_by_product_product foreign key(product_id) references product(product_id) on update cascade, constraint fk_category_by_product_category foreign key(category_id) references category(category_id) on update cascade );');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE public.product_product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE public.category_category_id_seq CASCADE');
        $this->addSql('DROP TABLE public.product');
        $this->addSql('DROP TABLE public.category');
        $this->addSql('DROP TABLE public.category_by_product');
    }
}
