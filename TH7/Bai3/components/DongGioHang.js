// Component CON: nhận dữ liệu bằng props, tuyệt đối không gán lại
// this.sanPham hoặc this.sanPham.soLuong.
const DongGioHang = {
  name: 'DongGioHang',
  props: {
    sanPham: { type: Object, required: true },
  },
  emits: ['doi-so-luong', 'yeu-cau-xoa'],

  computed: {
    thanhTien() {
      return this.sanPham.donGia * this.sanPham.soLuong;
    },
  },

  methods: {
    dinhDangTien(soTien) {
      return Number(soTien).toLocaleString('vi-VN') + ' đ';
    },
    tang() {
      // Gửi 2 tham số: id và số lượng MỚI (cha sẽ kiểm tra).
      this.$emit('doi-so-luong', this.sanPham.id, this.sanPham.soLuong + 1);
    },
    giam() {
      this.$emit('doi-so-luong', this.sanPham.id, this.sanPham.soLuong - 1);
    },
    xoa() {
      this.$emit('yeu-cau-xoa', this.sanPham.id);
    },
  },

  template: `
    <div class="cart-row">
      <span class="cart-title">{{ sanPham.ten }}</span>
      <span>{{ dinhDangTien(sanPham.donGia) }}</span>

      <div class="quantity">
        <button type="button" class="ghost"
                :disabled="sanPham.soLuong <= 1"
                @click="giam" aria-label="Giảm số lượng">−</button>
        <strong>{{ sanPham.soLuong }}</strong>
        <button type="button" class="ghost"
                :disabled="sanPham.soLuong >= 99"
                @click="tang" aria-label="Tăng số lượng">+</button>
      </div>

      <strong>{{ dinhDangTien(thanhTien) }}</strong>
      <button type="button" class="danger btn-small" @click="xoa">Xóa</button>
    </div>
  `,
};
