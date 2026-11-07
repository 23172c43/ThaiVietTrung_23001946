// Tệp component tái sử dụng: components/TheSanPham.js
// Khai báo đối tượng component để app.js đăng ký TRƯỚC khi mount.
const TheSanPham = {
  name: 'TheSanPham',

  props: {
    ten: { type: String, required: true },
    gia: { type: Number, required: true },
    anh: { type: String, required: true },
    moTa: { type: String, default: 'Chưa có mô tả cho sản phẩm này.' },
    soLuongTon: { type: Number, default: 0 },
  },

  emits: ['mua'],

  // Mỗi instance có data() riêng, nên nút mô tả độc lập nhau.
  data() {
    return { hienMoTa: false };
  },

  computed: {
    hetHang() {
      return this.soLuongTon === 0;
    },
  },

  methods: {
    dinhDangTien(soTien) {
      return Number(soTien).toLocaleString('vi-VN') + ' đ';
    },
    batTatMoTa() {
      this.hienMoTa = !this.hienMoTa;
    },
    mua() {
      if (!this.hetHang) this.$emit('mua', this.ten);
    },
  },

  template: `
    <article class="product-card">
      <img :src="anh" :alt="'Ảnh minh họa của ' + ten">
      <div class="product-body">
        <h3>{{ ten }}</h3>
        <p class="price">{{ dinhDangTien(gia) }}</p>
        <span class="badge" :class="hetHang ? 'out' : 'ok'">
          {{ hetHang ? 'Hết hàng' : 'Còn ' + soLuongTon + ' sản phẩm' }}
        </span>

        <p v-if="hienMoTa" class="desc">{{ moTa }}</p>

        <div class="product-actions">
          <button type="button" class="ghost btn-small"
                  :aria-expanded="String(hienMoTa)"
                  @click="batTatMoTa">
            {{ hienMoTa ? 'Ẩn mô tả' : 'Xem mô tả' }}
          </button>
          <button type="button" class="btn-small"
                  :disabled="hetHang" @click="mua">Mua</button>
        </div>
      </div>
    </article>
  `,
};
