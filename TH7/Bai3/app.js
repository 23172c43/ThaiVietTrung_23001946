const { createApp } = Vue;

// Sử dụng hàm để tạo dữ liệu ví dụ mới mỗi lần khôi phục.
function taoGioHangViDu() {
  return [
    { id: 1, ten: 'Bút', donGia: 5000, soLuong: 2 },
    { id: 2, ten: 'Vở', donGia: 12000, soLuong: 3 },
  ];
}

const app = createApp({
  data() {
    return {
      gioHang: taoGioHangViDu(),
      thongBao: '',
    };
  },

  computed: {
    tongSoLuong() {
      return this.gioHang.reduce((tong, sp) => tong + sp.soLuong, 0);
    },
    tongTien() {
      return this.gioHang.reduce(
        (tong, sp) => tong + sp.donGia * sp.soLuong, 0
      );
    },
  },

  methods: {
    dinhDangTien(soTien) {
      return Number(soTien).toLocaleString('vi-VN') + ' đ';
    },

    // Component CHA là nơi duy nhất thay đổi giỏ hàng.
    doiSoLuong(id, soLuongMoi) {
      if (!Number.isInteger(soLuongMoi) || soLuongMoi < 1 || soLuongMoi > 99) {
        this.thongBao = 'Số lượng phải là số nguyên từ 1 đến 99.';
        return;
      }
      const sanPham = this.gioHang.find(sp => sp.id === id);
      if (!sanPham) {
        this.thongBao = 'Không tìm thấy sản phẩm.';
        return;
      }
      // Tạo object mới thay vì sửa object props bên con.
      this.gioHang = this.gioHang.map(sp =>
        sp.id === id ? { ...sp, soLuong: soLuongMoi } : sp
      );
      this.thongBao = '';
    },

    xoaSanPham(id) {
      this.gioHang = this.gioHang.filter(sp => sp.id !== id);
      this.thongBao = '';
    },

    khoiPhucViDu() {
      this.gioHang = taoGioHangViDu();
      this.thongBao = '';
    },
  },
});

app.component('dong-gio-hang', DongGioHang);
app.mount('#app');
