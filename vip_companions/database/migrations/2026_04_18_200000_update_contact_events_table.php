<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop FK (this also removes the index created by it)
        DB::statement('ALTER TABLE contact_events DROP FOREIGN KEY contact_events_subscriber_user_id_foreign');

        // Rename column, drop contacted_at, change type — all in one ALTER
        DB::statement("ALTER TABLE contact_events
            CHANGE subscriber_user_id subscriber_id BIGINT UNSIGNED NOT NULL,
            DROP COLUMN contacted_at,
            MODIFY type VARCHAR(255) NOT NULL DEFAULT 'view'
        ");

        // Re-add FK on renamed column
        DB::statement('ALTER TABLE contact_events ADD CONSTRAINT contact_events_subscriber_id_foreign FOREIGN KEY (subscriber_id) REFERENCES users(id) ON DELETE CASCADE');

        // Add composite performance indexes
        DB::statement('CREATE INDEX contact_events_subscriber_id_created_at_index ON contact_events (subscriber_id, created_at)');
        DB::statement('CREATE INDEX contact_events_aviso_id_type_index ON contact_events (aviso_id, type)');
    }

    public function down(): void
    {
        DB::statement('DROP INDEX contact_events_subscriber_id_created_at_index ON contact_events');
        DB::statement('DROP INDEX contact_events_aviso_id_type_index ON contact_events');
        DB::statement('ALTER TABLE contact_events DROP FOREIGN KEY contact_events_subscriber_id_foreign');
        DB::statement("ALTER TABLE contact_events
            CHANGE subscriber_id subscriber_user_id BIGINT UNSIGNED NOT NULL,
            ADD contacted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            MODIFY type ENUM('email','phone','whatsapp','telegram') NOT NULL
        ");
        DB::statement('ALTER TABLE contact_events ADD CONSTRAINT contact_events_subscriber_user_id_foreign FOREIGN KEY (subscriber_user_id) REFERENCES users(id) ON DELETE CASCADE');
    }
};
