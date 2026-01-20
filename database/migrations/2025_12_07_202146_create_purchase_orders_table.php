    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('purchase_orders', function (Blueprint $table) {
                $table->id();
                $table->string('kode_po')->unique();
                $table->unsignedBigInteger('kategori_produk_id');
                $table->unsignedBigInteger('supplier_id');
                $table->string('nama_produk');
                $table->integer('harga_produk');
                $table->date('tanggal');
                $table->integer('jumlah');

                // FIELD BARU
                $table->integer('diskon')->nullable();     // boleh diisi / tidak
                $table->integer('pajak')->nullable();      // boleh diisi / tidak
                $table->integer('dp')->nullable();         // boleh diisi / tidak
                $table->integer('subtotal');               // hasil perhitungan
                $table->integer('grand_total');            // harga x jumlah (fix)

                $table->text('catatan')->nullable();
                $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

                // relasi
                $table->foreign('kategori_produk_id')
                    ->references('id')
                    ->on('kategori_produk')
                    ->onDelete('cascade');

                $table->foreign('supplier_id')
                    ->references('id')
                    ->on('suppliers')
                    ->onDelete('cascade');

                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('purchase_orders');
        }
    };
