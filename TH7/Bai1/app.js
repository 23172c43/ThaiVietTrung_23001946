// BÀI 1: Directive, methods, computed, watch, mounted.
// Chạy qua index.html (Vue 3 bản global được tải từ CDN).
const { createApp } = Vue;

createApp({
  data() {
    return {
      sanPhams: [
        { id: 1, ten: 'Bàn phím cơ',     gia: 850000, danhMuc: 'Phụ kiện',    tonKho: 12 },
        { id: 2, ten: 'Chuột không dây', gia: 320000, danhMuc: 'Phụ kiện',    tonKho: 0  },
        { id: 3, ten: 'Sách Vue 3',      gia: 180000, danhMuc: 'Sách',        tonKho: 8  },
        { id: 4, ten: 'Sách JavaScript', gia: 220000, danhMuc: 'Sách',        tonKho: 0  },
        { id: 5, ten: 'Áo thun',         gia: 150000, danhMuc: 'Thời trang', tonKho: 16 },
        { id: 6, ten: 'Áo khoác',        gia: 450000, danhMuc: 'Thời trang', tonKho: 4  },
      ],
      tuKhoa: '',
      danhMucChon: '',
      kieuSapXep: 'mac-dinh',
      canhBao: '',
      trangThai: 'Đang khởi tạo...',
      form: { ten: '', gia: '', danhMuc: 'Phụ kiện', tonKho: '' },
      thongBaoForm: '',
      loaiThongBao: 'success',
    };
  },

  computed: {
    // Danh mục có thể cập nhật nếu dữ liệu sản phẩm thay đổi.
    danhMucCoSan() {
      return [...new Set(this.sanPhams.map(sp => sp.danhMuc))];
    },

    // Thứ tự: tìm theo tên -> lọc danh mục -> sắp xếp trên BẢN SAO.
    sanPhamHienThi() {
      const tuKhoa = this.tuKhoa.trim().toLocaleLowerCase('vi-VN');
      let ketQua = this.sanPhams.filter(sp => {
        const khopTen = sp.ten.toLocaleLowerCase('vi-VN').includes(tuKhoa);
        const khopDanhMuc = !this.danhMucChon || sp.danhMuc === this.danhMucChon;
        return khopTen && khopDanhMuc;
      });

      // .slice() tạo mảng mới, tránh sort() làm đổi mảng gốc.
      ketQua = ketQua.slice();
      if (this.kieuSapXep === 'tang') {
        ketQua.sort((a, b) => a.gia - b.gia);
      } else if (this.kieuSapXep === 'giam') {
        ketQua.sort((a, b) => b.gia - a.gia);
      }
      return ketQua;
    },

    soLuongHienThi() {
      return this.sanPhamHienThi.length;
    },

    tongGiaTriTonKho() {
      // Nếu danh sách rỗng, reduce(..., 0) trả về 0.
      return this.sanPhamHienThi.reduce(
        (tong, sp) => tong + sp.gia * sp.tonKho, 0
      );
    },
  },

  watch: {
    // Gọi mỗi khi người dùng thay đổi từ khóa tìm kiếm.
    tuKhoa(giaTriMoi) {
      this.canhBao = giaTriMoi.trim().length === 1
        ? 'Vui lòng nhập ít nhất 2 ký tự để tìm kiếm chính xác hơn.'
        : '';
    },
  },

  methods: {
    dinhDangTien(soTien) {
      return Number(soTien).toLocaleString('vi-VN') + ' đ';
    },

    themSanPham() {
      this.thongBaoForm = '';
      const ten = this.form.ten.trim();
      const gia = Number(this.form.gia);
      const tonKho = Number(this.form.tonKho);

      if (!ten) {
        return this.hienLoi('Tên sản phẩm không được để trống.');
      }
      if (this.form.gia === '' || !Number.isFinite(gia) || gia <= 0) {
        return this.hienLoi('Giá sản phẩm phải là số lớn hơn 0.');
      }
      if (this.form.tonKho === '' || !Number.isInteger(tonKho) || tonKho < 0) {
        return this.hienLoi('Tồn kho phải là số nguyên không âm.');
      }
      if (!this.form.danhMuc) {
        return this.hienLoi('Hãy chọn danh mục sản phẩm.');
      }

      const idMoi = Math.max(0, ...this.sanPhams.map(sp => sp.id)) + 1;
      this.sanPhams.push({
        id: idMoi, ten, gia, danhMuc: this.form.danhMuc, tonKho,
      });
      this.loaiThongBao = 'success';
      this.thongBaoForm = `Đã thêm sản phẩm "${ten}" (ID ${idMoi}).`;
      this.form = { ten: '', gia: '', danhMuc: 'Phụ kiện', tonKho: '' };
    },

    hienLoi(noiDung) {
      this.loaiThongBao = 'error';
      this.thongBaoForm = noiDung;
    },

    xoaSanPham(id) {
      const sanPham = this.sanPhams.find(sp => sp.id === id);
      if (!sanPham) return;
      if (!window.confirm(`Bạn có chắc muốn xóa "${sanPham.ten}"?`)) return;
      this.sanPhams = this.sanPhams.filter(sp => sp.id !== id);
      this.loaiThongBao = 'success';
      this.thongBaoForm = `Đã xóa sản phẩm "${sanPham.ten}".`;
    },
  },

  mounted() {
    this.trangThai = 'Sẵn sàng';
  },
}).mount('#app');
