<?php

use App\Enums\Property\PropertyBedroom;
use App\Enums\Property\PropertyStatus;
use App\Enums\Property\PropertyType;
use App\Models\Area;
use App\Models\Contact;
use App\Models\District;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->text('description_id')->nullable();
            $table->text('description_zh')->nullable();
            $table->text('description_fr')->nullable();
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->date('availability_date')->nullable();
            $table->date('visit_date')->nullable();
            $table->year('year_built')->nullable();
            $table->date('completion_date')->nullable();
            $table->unsignedTinyInteger('bedroom')->default(PropertyBedroom::OneBedroom->value);

            $table->string('villa_name', 50)->nullable();
            $table->text('google_maps_url')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('address', 200)->nullable();
            $table->foreignIdFor(District::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Area::class)->nullable()->constrained()->nullOnDelete();

            $table->integer('land_size')->nullable();
            $table->integer('building_size')->unsigned()->nullable();
            $table->tinyInteger('number_of_floors')->unsigned()->nullable();
            $table->integer('outdoor_area_size')->unsigned()->nullable();
            $table->string('pool_size', 50)->nullable();

            $table->tinyInteger('number_of_bathrooms')->unsigned()->nullable();
            $table->boolean('ensuite_bathrooms')->unsigned()->default(false);
            $table->boolean('guest_toilet')->unsigned()->default(false);
            $table->boolean('storage')->unsigned()->default(false);
            $table->boolean('living_style')->unsigned()->nullable();

            $table->boolean('full_legal_documentation')->default(false);
            $table->boolean('signed_listing_agreement')->default(false);
            $table->boolean('lease_agreement')->default(false);
            $table->boolean('land_certificate')->default(false);
            $table->boolean('owners_id')->default(false);
            $table->boolean('imb')->default(false);
            $table->boolean('pbg')->default(false);
            $table->boolean('slf')->default(false);

            $table->boolean('fully_furnished')->default(false);
            $table->boolean('rental_type')->unsigned()->nullable();
            $table->integer('minimum_rental_duration_months')->unsigned()->nullable();
            $table->boolean('owner_price_flexibility')->unsigned()->nullable();
            $table->boolean('price_coherent_with_upper')->default(false);

            $table->boolean('not_directly_exposed_to_main_road')->unsigned()->default(false);
            $table->boolean('no_festive_venue_nearby')->unsigned()->default(false);
            $table->boolean('no_ongoing')->unsigned()->default(false);
            $table->boolean('quiet_access_road')->unsigned()->default(false);
            $table->boolean('orientation')->unsigned()->nullable();
            $table->text('view')->nullable();

            $table->boolean('living_area_has_natural_light')->unsigned()->default(false);
            $table->boolean('bedroom_1_has_natural_light')->unsigned()->default(false);
            $table->boolean('bedroom_2_has_natural_light')->unsigned()->default(false);
            $table->text('noise_source_identified')->nullable();

            $table->integer('internet_speedtest')->nullable();
            $table->string('internet_speedtest_image_path', 50)->unique()->nullable();
            $table->boolean('power_backup')->unsigned()->nullable();
            $table->boolean('water_source')->unsigned()->nullable();
            $table->boolean('electricity')->unsigned()->nullable();

            $table->boolean('eligible_for_upper')->unsigned()->default(false);
            $table->boolean('eligible_for_premium')->unsigned()->default(false);

            $table->boolean('design_driven_property')->unsigned()->default(false);
            $table->text('usability_limitations')->nullable();

            $table->boolean('trade_off_identified')->unsigned()->default(false);
            $table->text('trade_off_description')->nullable();
            $table->json('target_profiles')->nullable();

            $table->boolean('operational_risk')->unsigned()->nullable();
            $table->text('operational_risk_comment')->nullable();

            $table->unsignedBigInteger('monthly_price')->default(0);
            $table->unsignedBigInteger('yearly_price')->default(0);
            $table->json('monthly_inclusions')->nullable();
            $table->json('yearly_inclusions')->nullable();

            $table->foreignIdFor(Contact::class, 'owner_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Contact::class, 'owner_representative_id')->nullable()->constrained()->nullOnDelete();

            $table->boolean('listing_type')->unsigned()->nullable();

            $table->string('image_path', 50)->unique()->nullable();
            $table->boolean('type')->unsigned()->default(PropertyType::Villa);
            $table->boolean('status')->unsigned()->default(PropertyStatus::Pending);
            $table->string('slug', 50)->unique();
            $table->string('folder_id', 50)->unique()->nullable();
            $table->unsignedInteger('counter')->default(0);

            $table->foreignIdFor(User::class, 'created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignIdFor(User::class, 'updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignIdFor(User::class, 'deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
