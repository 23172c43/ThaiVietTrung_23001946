// Component cha: giữ mảng sản phẩm và nhận event 'mua'.
const { createApp } = Vue;

const app = createApp({
  data() {
    return {
      thongBao: '',
      sanPhams: [
        {
          id: 1, ten: 'Tai nghe không dây', gia: 590000,
          anh: 'assets/tai-nghe.svg',
          moTa: 'Tai nghe Bluetooth nhẹ, phù hợp học tập và nghe nhạc.',
          soLuongTon: 10,
        },
        {
          id: 2, ten: 'Bàn phím mini', gia: 720000,
          anh: 'assets/ban-phim.svg',
          moTa: 'Bàn phím nhỏ gọn, tiết kiệm không gian bàn học.',
          soLuongTon: 0,
        },
        {
          id: 3, ten: 'Bình giữ nhiệt', gia: 190000,
          anh: 'assets/binh-nuoc.svg',
          moTa: 'Bình giữ nhiệt dung tích 500 ml, dễ mang theo.',
          soLuongTon: 7,
        },
        {
          id: 4, ten: 'Balo laptop', gia: 420000,
          anh: 'assets/balo.svg',
          moTa: 'Balo có ngăn laptop và nhiều ngăn nhỏ tiện dụng.',
          soLuongTon: 3,
        },
      ],
    };
  },
  methods: {
    baoMua(tenSanPham) {
      this.thongBao = `Bạn đã chọn mua: ${tenSanPham}. (Ví dụ minh họa.)`;
    },
  },
});

// Đăng ký trước khi app.mount(): theo đúng yêu cầu đề bài.
app.component('the-san-pham', TheSanPham);
app.mount('#app');
