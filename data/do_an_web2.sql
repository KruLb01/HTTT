-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2021 at 10:00 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `do_an_web2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_nguoidung` varchar(20) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `thong_tin_khac` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_nguoidung`, `ho_ten`, `thong_tin_khac`) VALUES
('admin', 'Leos Heros', 'I am alive ! <3'),
('manager', 'Kao Heros', 'F*ck this project :<'),
('employee1', 'Lê Thanh Hòa', ''),
('employee1', 'Lê Thanh Hòa', ''),
('employee1', 'Lê Thanh Hòa', ''),
('employee1', 'Lê Thanh Hòa', ''),
('nv001', 'Lê Thanh Hòa', '');

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_danhgia`
--

CREATE TABLE `chitiet_danhgia` (
  `id_danhgia` varchar(10) NOT NULL,
  `hinhanh_danhgia` varchar(10) NOT NULL,
  `comment` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_giaohang`
--

CREATE TABLE `chitiet_giaohang` (
  `id_hoadon` varchar(50) NOT NULL,
  `phuongthuc_giaohang` varchar(50) NOT NULL,
  `ngay_giao` date NOT NULL,
  `tinhtrang_giaohang` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chitiet_giaohang`
--

INSERT INTO `chitiet_giaohang` (`id_hoadon`, `phuongthuc_giaohang`, `ngay_giao`, `tinhtrang_giaohang`) VALUES
('23', 'GH-1', '0000-00-00', 2),
('24', 'GH-1', '2021-05-12', 3),
('25', 'GH-1', '0000-00-00', 2),
('26', 'GH-1', '2021-05-12', 3),
('27', 'GH-1', '0000-00-00', 1),
('28', 'GH-1', '0000-00-00', 2),
('29', 'GH-1', '2021-05-12', 3),
('30', 'GH-1', '2021-05-12', 3),
('31', 'GH-1', '0000-00-00', 1),
('0', 'GH-1', '2021-05-13', 3);

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_hoadon`
--

CREATE TABLE `chitiet_hoadon` (
  `id_hoadon` varchar(50) NOT NULL,
  `id_sanpham` varchar(50) NOT NULL,
  `so_luong` int(10) NOT NULL,
  `gia` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chitiet_hoadon`
--

INSERT INTO `chitiet_hoadon` (`id_hoadon`, `id_sanpham`, `so_luong`, `gia`) VALUES
('23', '1S33', 10, 1550000),
('24', '1S31', 1, 1000000),
('25', '1S31', 1, 1000000),
('26', '9S33', 10, 2000000),
('27', '2S31', 2, 1500000),
('28', '2S31', 1, 1500000),
('29', '2S31', 1, 1500000),
('30', '2S31', 1, 1500000),
('31', '2S31', 5, 2000000),
('0', '1S31', 2, 2000000),
('0', '2S31', 5, 7500000);

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_phieunhap`
--

CREATE TABLE `chitiet_phieunhap` (
  `id_phieunhap` varchar(100) NOT NULL,
  `id_sanpham` varchar(100) NOT NULL,
  `so_luong` int(10) NOT NULL,
  `gia_nhap` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chitiet_phieunhap`
--

INSERT INTO `chitiet_phieunhap` (`id_phieunhap`, `id_sanpham`, `so_luong`, `gia_nhap`) VALUES
('PN-609b75613c30d8.21739231', '2S31', 20, 200000),
('PN-609b75613c30d8.21739231', '1S33', 20, 300000),
('PN-609bf5a8a85c33.15643328', '2S31', 20, 200000);

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_quyen_chucnang`
--

CREATE TABLE `chitiet_quyen_chucnang` (
  `id_quyen` varchar(20) NOT NULL,
  `id_chucnang` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chitiet_quyen_chucnang`
--

INSERT INTO `chitiet_quyen_chucnang` (`id_quyen`, `id_chucnang`) VALUES
('admin', '4'),
('admin', '1'),
('admin', '2'),
('admin', '3'),
('admin', '6'),
('admin', '9'),
('admin', '10'),
('admin', '12'),
('admin', '17'),
('manager', '1'),
('manager', '2'),
('manager', '3'),
('manager', '4'),
('manager', '6'),
('manager', '9'),
('manager', '10'),
('manager', '12'),
('manager', '14'),
('manager', '16'),
('manager', '17'),
('manager', '18'),
('manager', '19'),
('admin', '14'),
('admin', '16'),
('admin', '18'),
('admin', '19'),
('travellers', '1'),
('travellers', '2'),
('travellers', '3'),
('travellers', '4'),
('travellers', '5'),
('travellers', '6'),
('travellers', '9'),
('travellers', '10'),
('travellers', '11'),
('travellers', '17'),
('travellers', '16'),
('travellers', '18'),
('travellers', '19'),
('admin', '7'),
('admin', '8'),
('admin', '20'),
('admin', '21'),
('admin', '22'),
('admin', '23'),
('manager', '23'),
('manager', '7'),
('manager', '22'),
('manager', '8'),
('manager', '20'),
('manager', '21');

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_sale`
--

CREATE TABLE `chitiet_sale` (
  `id_sale` varchar(10) NOT NULL,
  `id_nhomsanpham` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chitiet_sale`
--

INSERT INTO `chitiet_sale` (`id_sale`, `id_nhomsanpham`) VALUES
('2', '10');

-- --------------------------------------------------------

--
-- Table structure for table `chuc_nang`
--

CREATE TABLE `chuc_nang` (
  `id_chucnang` int(100) NOT NULL,
  `ten_chucnang` varchar(100) NOT NULL,
  `mieuta` varchar(100) NOT NULL,
  `vi_tri` varchar(10) NOT NULL,
  `icon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chuc_nang`
--

INSERT INTO `chuc_nang` (`id_chucnang`, `ten_chucnang`, `mieuta`, `vi_tri`, `icon`) VALUES
(1, 'Manage Accounts', '', '1000', '<i class=\"fas fa-users\" style=\"padding-right: 8px;\"></i>'),
(2, 'Manage Customers', '', '1001', ''),
(3, 'Manage Employees', '', '1002', ''),
(4, 'Manage Permission', '', '1003', ''),
(6, 'Manage Store', '', '2000', '<i class=\"fas fa-cubes\" style=\"padding-right: 8px;\"></i>'),
(7, 'Manage Products', '', '2010', ''),
(8, 'Import Products', '', '2020', ''),
(9, 'Manage Revenue', '', '3000', '<i class=\"fas fa-receipt\" style=\"padding-right: 10px;padding-left:4px\"></i>'),
(10, 'Track Invoice', '', '3001', ''),
(12, 'Manage Sales', '', '4000', '<i class=\"fas fa-money-bill-alt\" style=\"padding-right: 8px;\"></i>'),
(14, 'Track Sales', '', '4002', ''),
(16, 'Activity', '', '5000', '<i class=\"fas fa-chart-line\" style=\"padding-right: 10px;\"></i>'),
(17, 'Mail', '', '6000', '<i class=\"fas fa-mail-bulk\" style=\"padding-right: 8px;\"></i>'),
(18, 'Help', '', '7000', '<i class=\"fas fa-question\"  style=\"padding-right: 14px;\"></i>'),
(19, 'Log out', '', '8000', '<i class=\"fas fa-sign-out-alt\"  style=\"padding-right: 10px;\"></i>'),
(20, 'Manage Import', '', '2030', ''),
(21, 'Manage Providers', '', '2040', ''),
(22, 'Manage cProducts', '', '2011', ''),
(23, 'Manage gProducts', '', '2005', '');

-- --------------------------------------------------------

--
-- Table structure for table `danh_gia`
--

CREATE TABLE `danh_gia` (
  `id_danhgia` varchar(10) NOT NULL,
  `id_nhomsanpham` varchar(10) NOT NULL,
  `id_hoadon` varchar(10) NOT NULL,
  `id_khachhang` varchar(10) NOT NULL,
  `sosao_danhgia` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dong_san_pham`
--

CREATE TABLE `dong_san_pham` (
  `id_dongsanpham` varchar(10) NOT NULL,
  `ten_dongsanpham` varchar(50) NOT NULL,
  `thuonghieu_sanpham` varchar(20) NOT NULL,
  `mota` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dong_san_pham`
--

INSERT INTO `dong_san_pham` (`id_dongsanpham`, `ten_dongsanpham`, `thuonghieu_sanpham`, `mota`) VALUES
('ADS', 'Adidas Super Star', 'Adidas', 'Đây được xem là một trong những dòng sản phẩm khá lâu đời của thương hiệu Adidas mà hầu hết tất cả khách hàng ai cũng đều biết. Tuy có tuổi đời như thế nhưng độ chất của sản phẩm không hề thua kém so với những đàn em của mình. Dòng sản phẩm này hiện vẫn đang được rất nhiều khách hàng lựa chọn và luôn khẳng định vị thế của mình trên thị trường. Có thể nói rằng, cho dù thế giới giày thể thao thương hiệu xoay vần như thế nào đi chăng nữa thì Adidas nữ super star vẫn bất biến.\r\n\r\nLý giải cho điều này, nhiều khách hàng cho hay rằng sở dĩ họ vẫn trung thành với super star là bởi giày có thể ăn rơ với mọi loại trang phục thời trang bất kỳ. Điều khiến những đôi giày adidas superstar đặc biệt chính là phần mũi vỏ sò (shelltoe), kết hợp với nét đặc trưng của phần thân giày được thiết kế có ba sọc cổ điển của adidas. Đặc biệt, nét đặc trưng của dòng giày này là luôn được làm bằng chất liệu da ở phần 3 sọc cổ điển đó. Và mỗi năm Adidas luôn cho ra mắt một phiên bản mới để thỏa lòng yêu thích sưu tập của các khách hàng thân thiết'),
('BHR', 'Bitis Hunter Running', 'Bitis', 'Hunter Running thế hệ giày chạy bộ chuyên biệt đầu tiên được phát triển bởi Biti’s ra đời tiếp nối sự thành công của Biti’s Hunter trên thị trường hiện nay'),
('CV70s', 'Converse 1970s', 'Converse', 'converse 1970S replica là một thành viên trong đại gia đình converse, được nhiều bạn trẻ yêu quý. Item này luôn thuộc top bán chạy trong danh sách những đôi giày sneaker đình đám. Đặc điểm nổi bật chính là phong cách cổ điển, độ bền gần như là vô đối so với các loại giày cùng phân khúc.'),
('CVC', 'Converse Classic', 'Converse', 'Giày Converse classic là dòng giày truyền thống của Converse được thiết kế với nguyên bản mẫu thiết kế ban đầu, giữ được những nét nổi bật đặc trưng của thương hiệu giày nổi tiếng converse'),
('CVK', 'Converse Kids', 'Converse', 'Thương hiệu Converse với mẫu giày được thiết kế dành riêng cho trẻ em'),
('NAX', 'Nike Air Max', 'Nike', 'Giày Nike Air Max được đặt tên theo công nghệ mà nó sở hữu – công nghệ Air Max sử dụng phần lớn (max) đệm khí air cho phần đế giữa. Đôi giày này không chỉ sở hữu công nghệ đệm tuyệt vời mà còn chiếm lĩnh một vẻ ngoài sang trọng và đẳng cấp đến bất ngờ. Hiện nay, giày Nike Air Max được mệnh danh là dòng giày tiên phong mũi nhọn của hãng Nike và nhận được lượt tìm kiếm nhiều nhất trên các trang mạng');

-- --------------------------------------------------------

--
-- Table structure for table `gio_hang`
--

CREATE TABLE `gio_hang` (
  `id_nguoidung` varchar(10) NOT NULL,
  `id_sanpham` varchar(10) NOT NULL,
  `so_luong` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hinh_anh`
--

CREATE TABLE `hinh_anh` (
  `id_hinhanh` varchar(100) NOT NULL,
  `link_hinhanh` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hinh_anh`
--

INSERT INTO `hinh_anh` (`id_hinhanh`, `link_hinhanh`) VALUES
('Bitis Hunter Orange-608acb158de408.09638614.png', 'images/Bitis Hunter Orange-608acb158de408.09638614.png'),
('Bitis Hunter Orange-608acb234d9756.07461710.png', 'images/Bitis Hunter Orange-608acb234d9756.07461710.png'),
('Bitis Hunter Running Blue-609b33aed8f1b6.07242303.jpg', 'images/Bitis Hunter Running Blue-609b33aed8f1b6.07242303.jpg'),
('Bitis Hunter Running Blue-609b33b12f2213.45928297.jpg', 'images/Bitis Hunter Running Blue-609b33b12f2213.45928297.jpg'),
('Bitis Hunter Running Blue-609b33b3707f62.93239615.jpg', 'images/Bitis Hunter Running Blue-609b33b3707f62.93239615.jpg'),
('Bitis Hunter Running Blue-609b33b5f1d9c7.32037219.jpg', 'images/Bitis Hunter Running Blue-609b33b5f1d9c7.32037219.jpg'),
('Bitis Hunter Running Blue-609b33b8706391.03613072.jpg', 'images/Bitis Hunter Running Blue-609b33b8706391.03613072.jpg'),
('Bitis Hunter Running Orange-609b33cba0fc84.63658370.jpg', 'images/Bitis Hunter Running Orange-609b33cba0fc84.63658370.jpg'),
('Bitis Hunter Running Orange-609b33cdc81d41.77383850.jpg', 'images/Bitis Hunter Running Orange-609b33cdc81d41.77383850.jpg'),
('Bitis Hunter Running Orange-609b33d0241cd7.38434452.jpg', 'images/Bitis Hunter Running Orange-609b33d0241cd7.38434452.jpg'),
('Bitis Hunter Running Orange-609b33d27796f2.87103467.jpg', 'images/Bitis Hunter Running Orange-609b33d27796f2.87103467.jpg'),
('Bitis Hunter Running Orange-609b33d4a85a40.67001558.jpg', 'images/Bitis Hunter Running Orange-609b33d4a85a40.67001558.jpg'),
('Converse Taylor Science Canvas Trainers-609b3420c0b213.48504869.jpg', 'images/Converse Taylor Science Canvas Trainers-609b3420c0b213.48504869.jpg'),
('Converse Taylor Science Canvas Trainers-609b3422ef9f81.20540290.jpg', 'images/Converse Taylor Science Canvas Trainers-609b3422ef9f81.20540290.jpg'),
('Converse Taylor Science Canvas Trainers-609b342542c0f2.33335262.jpg', 'images/Converse Taylor Science Canvas Trainers-609b342542c0f2.33335262.jpg'),
('Converse Taylor Science Canvas Trainers-609b34277fc853.59882335.jpg', 'images/Converse Taylor Science Canvas Trainers-609b34277fc853.59882335.jpg'),
('Converse Chuck Taylor All Star Gamer Low-Top-609b3475716868.94117718.jpg', 'images/Converse Chuck Taylor All Star Gamer Low-Top-609b3475716868.94117718.jpg'),
('Converse Chuck Taylor All Star Gamer Low-Top-609b3477b20aa2.66359901.jpg', 'images/Converse Chuck Taylor All Star Gamer Low-Top-609b3477b20aa2.66359901.jpg'),
('Converse Chuck Taylor All Star Gamer Low-Top-609b3479949534.92579539.jpg', 'images/Converse Chuck Taylor All Star Gamer Low-Top-609b3479949534.92579539.jpg'),
('Converse Chuck Taylor All Star Gamer Low-Top-609b347c840983.88223319.jpg', 'images/Converse Chuck Taylor All Star Gamer Low-Top-609b347c840983.88223319.jpg'),
('Converse Chuck Taylor Classic Black-White Low Top-609b34b5577469.01026026.jpg', 'images/Converse Chuck Taylor Classic Black-White Low Top-609b34b5577469.01026026.jpg'),
('Converse Chuck Taylor Classic Black-White Low Top-609b34bd50f540.30142022.jpg', 'images/Converse Chuck Taylor Classic Black-White Low Top-609b34bd50f540.30142022.jpg'),
('Converse Chuck Taylor Classic Black-White Low Top-609b34c2cd2588.50102978.jpg', 'images/Converse Chuck Taylor Classic Black-White Low Top-609b34c2cd2588.50102978.jpg'),
('Converse Chuck 70 Archive Paint Splatter High Top Black-609b3513af9398.94380953.jpg', 'images/Converse Chuck 70 Archive Paint Splatter High Top Black-609b3513af9398.94380953.jpg'),
('Converse Chuck 70 Archive Paint Splatter High Top Black-609b35163e1928.34468863.jpg', 'images/Converse Chuck 70 Archive Paint Splatter High Top Black-609b35163e1928.34468863.jpg'),
('Converse Chuck 70 Archive Paint Splatter High Top Black-609b35187d3814.48482885.jpg', 'images/Converse Chuck 70 Archive Paint Splatter High Top Black-609b35187d3814.48482885.jpg'),
('Converse Chuck 70 Archive Paint Splatter High Top Black-609b351ad23e43.09365208.jpg', 'images/Converse Chuck 70 Archive Paint Splatter High Top Black-609b351ad23e43.09365208.jpg'),
('Converse Chuck 70 Archive Paint Splatter High Top Black-609b351d9d30f7.94371820.jpg', 'images/Converse Chuck 70 Archive Paint Splatter High Top Black-609b351d9d30f7.94371820.jpg'),
('Converse Chuck 70 Archive Paint Splatter High Top White-609b353008d351.88572018.jpg', 'images/Converse Chuck 70 Archive Paint Splatter High Top White-609b353008d351.88572018.jpg'),
('Converse Chuck 70 Archive Paint Splatter High Top White-609b3532011914.99988326.jpg', 'images/Converse Chuck 70 Archive Paint Splatter High Top White-609b3532011914.99988326.jpg'),
('Converse Chuck 70 Archive Paint Splatter High Top White-609b3533f1ad33.11670814.jpg', 'images/Converse Chuck 70 Archive Paint Splatter High Top White-609b3533f1ad33.11670814.jpg'),
('Converse Chuck 70 Archive Paint Splatter High Top White-609b353a6285e0.78918601.jpg', 'images/Converse Chuck 70 Archive Paint Splatter High Top White-609b353a6285e0.78918601.jpg'),
('Converse Chuck 70 Archive Paint Splatter High Top White-609b353e4d7976.86496106.jpg', 'images/Converse Chuck 70 Archive Paint Splatter High Top White-609b353e4d7976.86496106.jpg'),
('Converse Chuck 70 Archive Paint Splatter High Top White-609b3540a254a0.34805723.jpg', 'images/Converse Chuck 70 Archive Paint Splatter High Top White-609b3540a254a0.34805723.jpg'),
('Adidas Slip-on SuperStar-609b36682fede7.10313462.png', 'images/Adidas Slip-on SuperStar-609b36682fede7.10313462.png'),
('Adidas Slip-on SuperStar-609b366a7e85a1.85471212.png', 'images/Adidas Slip-on SuperStar-609b366a7e85a1.85471212.png'),
('Adidas Slip-on SuperStar-609b366c5dfdd4.82710359.png', 'images/Adidas Slip-on SuperStar-609b366c5dfdd4.82710359.png'),
('Adidas Slip-on SuperStar-609b366e889259.52517273.png', 'images/Adidas Slip-on SuperStar-609b366e889259.52517273.png'),
('Adidas Slip-on SuperStar-609b36726c3062.15971620.png', 'images/Adidas Slip-on SuperStar-609b36726c3062.15971620.png'),
('Nike Air Max 97 Essential-609b367b2a22d9.29917339.png', 'images/Nike Air Max 97 Essential-609b367b2a22d9.29917339.png'),
('Nike Air Max 97 Essential-609b367d55c514.67014990.png', 'images/Nike Air Max 97 Essential-609b367d55c514.67014990.png'),
('Nike Air Max 97 Essential-609b367f9a0922.27891191.png', 'images/Nike Air Max 97 Essential-609b367f9a0922.27891191.png'),
('Nike Air Max 97 Essential-609b3682045663.20998192.png', 'images/Nike Air Max 97 Essential-609b3682045663.20998192.png'),
('Nike Air Max 97 Essential-609b36840b9ef7.25248825.png', 'images/Nike Air Max 97 Essential-609b36840b9ef7.25248825.png'),
('Bitis Hunter Running Cyan-609cda9559c9b9.43401745.png', 'images/Bitis Hunter Running Cyan-609cda9559c9b9.43401745.png');

-- --------------------------------------------------------

--
-- Table structure for table `hinh_nhomsanpham`
--

CREATE TABLE `hinh_nhomsanpham` (
  `id_nhomsanpham` varchar(100) NOT NULL,
  `id_hinh` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hinh_nhomsanpham`
--

INSERT INTO `hinh_nhomsanpham` (`id_nhomsanpham`, `id_hinh`) VALUES
('1', 'Bitis Hunter Running Blue-609b33aed8f1b6.07242303.jpg'),
('1', 'Bitis Hunter Running Blue-609b33b12f2213.45928297.jpg'),
('1', 'Bitis Hunter Running Blue-609b33b3707f62.93239615.jpg'),
('1', 'Bitis Hunter Running Blue-609b33b5f1d9c7.32037219.jpg'),
('1', 'Bitis Hunter Running Blue-609b33b8706391.03613072.jpg'),
('2', 'Bitis Hunter Running Orange-609b33cba0fc84.63658370.jpg'),
('2', 'Bitis Hunter Running Orange-609b33cdc81d41.77383850.jpg'),
('2', 'Bitis Hunter Running Orange-609b33d0241cd7.38434452.jpg'),
('2', 'Bitis Hunter Running Orange-609b33d27796f2.87103467.jpg'),
('2', 'Bitis Hunter Running Orange-609b33d4a85a40.67001558.jpg'),
('3', 'Converse Taylor Science Canvas Trainers-609b3420c0b213.48504869.jpg'),
('3', 'Converse Taylor Science Canvas Trainers-609b3422ef9f81.20540290.jpg'),
('3', 'Converse Taylor Science Canvas Trainers-609b342542c0f2.33335262.jpg'),
('3', 'Converse Taylor Science Canvas Trainers-609b34277fc853.59882335.jpg'),
('4', 'Converse Chuck Taylor All Star Gamer Low-Top-609b3475716868.94117718.jpg'),
('4', 'Converse Chuck Taylor All Star Gamer Low-Top-609b3477b20aa2.66359901.jpg'),
('4', 'Converse Chuck Taylor All Star Gamer Low-Top-609b3479949534.92579539.jpg'),
('4', 'Converse Chuck Taylor All Star Gamer Low-Top-609b347c840983.88223319.jpg'),
('5', 'Converse Chuck Taylor Classic Black-White Low Top-609b34b5577469.01026026.jpg'),
('5', 'Converse Chuck Taylor Classic Black-White Low Top-609b34bd50f540.30142022.jpg'),
('5', 'Converse Chuck Taylor Classic Black-White Low Top-609b34c2cd2588.50102978.jpg'),
('6', 'Converse Chuck 70 Archive Paint Splatter High Top Black-609b3513af9398.94380953.jpg'),
('6', 'Converse Chuck 70 Archive Paint Splatter High Top Black-609b35163e1928.34468863.jpg'),
('6', 'Converse Chuck 70 Archive Paint Splatter High Top Black-609b35187d3814.48482885.jpg'),
('6', 'Converse Chuck 70 Archive Paint Splatter High Top Black-609b351ad23e43.09365208.jpg'),
('6', 'Converse Chuck 70 Archive Paint Splatter High Top Black-609b351d9d30f7.94371820.jpg'),
('7', 'Converse Chuck 70 Archive Paint Splatter High Top White-609b353008d351.88572018.jpg'),
('7', 'Converse Chuck 70 Archive Paint Splatter High Top White-609b3532011914.99988326.jpg'),
('7', 'Converse Chuck 70 Archive Paint Splatter High Top White-609b353a6285e0.78918601.jpg'),
('7', 'Converse Chuck 70 Archive Paint Splatter High Top White-609b353e4d7976.86496106.jpg'),
('7', 'Converse Chuck 70 Archive Paint Splatter High Top White-609b3540a254a0.34805723.jpg'),
('8', 'Adidas Slip-on SuperStar-609b36682fede7.10313462.png'),
('8', 'Adidas Slip-on SuperStar-609b366a7e85a1.85471212.png'),
('8', 'Adidas Slip-on SuperStar-609b366c5dfdd4.82710359.png'),
('8', 'Adidas Slip-on SuperStar-609b366e889259.52517273.png'),
('8', 'Adidas Slip-on SuperStar-609b36726c3062.15971620.png'),
('9', 'Nike Air Max 97 Essential-609b367b2a22d9.29917339.png'),
('9', 'Nike Air Max 97 Essential-609b367d55c514.67014990.png'),
('9', 'Nike Air Max 97 Essential-609b367f9a0922.27891191.png'),
('9', 'Nike Air Max 97 Essential-609b3682045663.20998192.png'),
('9', 'Nike Air Max 97 Essential-609b36840b9ef7.25248825.png'),
('10', 'Bitis Hunter Running Cyan-609cda9559c9b9.43401745.png');

-- --------------------------------------------------------

--
-- Table structure for table `hoa_don`
--

CREATE TABLE `hoa_don` (
  `id_hoadon` int(255) NOT NULL,
  `id_nguoidung` varchar(50) NOT NULL,
  `id_nhanvienban` varchar(50) NOT NULL,
  `ngay_mua` date NOT NULL,
  `tong_gia` int(32) NOT NULL,
  `id_sale` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hoa_don`
--

INSERT INTO `hoa_don` (`id_hoadon`, `id_nguoidung`, `id_nhanvienban`, `ngay_mua`, `tong_gia`, `id_sale`) VALUES
(23, '1', 'manager', '2021-05-11', 15500000, '15'),
(24, '1', 'manager', '2021-05-11', 1000000, '14'),
(25, '1', '', '2021-05-11', 1000000, '15'),
(26, '1', 'manager', '2021-05-11', 20000000, '13'),
(27, '2', '', '2021-05-11', 3000000, '12'),
(28, '2', 'manager', '2021-05-11', 1500000, '11'),
(29, '2', 'manager', '2021-05-11', 1500000, '11'),
(30, '2', 'manager', '2021-05-11', 1500000, '12'),
(31, '2', '', '2021-05-11', 10000000, '12'),
(0, '1', 'admin', '2021-05-13', 9500000, '');

-- --------------------------------------------------------

--
-- Table structure for table `khach_hang`
--

CREATE TABLE `khach_hang` (
  `id_nguoidung` int(11) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `dia_chi` varchar(100) NOT NULL,
  `thong_tin_khac` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `khach_hang`
--

INSERT INTO `khach_hang` (`id_nguoidung`, `ho_ten`, `dia_chi`, `thong_tin_khac`) VALUES
(1, 'Lê Thanh Hòa', 'On the Sunns', 'I am still alive'),
(2, 'David Heros', 'On the Earth', ''),
(3, 'David Heros', 'On the Earth', ''),
(4, 'David Heros', 'On the Earth', ''),
(5, 'David Heros', 'On the Earth', ''),
(6, 'Helen Heros', 'On the March', ''),
(7, 'Helen Heros', 'On the March', ''),
(8, 'Helen Heros', 'On the March', ''),
(9, 'Helen Heros', 'On the March', ''),
(10, 'Helen Heros', 'On the March', ''),
(11, 'Helen Heros', 'On the March', ''),
(12, 'Kali Heros', 'On the Moon', ''),
(13, 'Kali Heros', 'On the Moon', ''),
(14, 'Kali Heros', 'On the Moon', ''),
(15, 'Kali Heros', 'On the Moon', ''),
(16, 'Kali Heros', 'On the Moon', ''),
(17, 'Kali Heros', 'On the Moon', ''),
(18, 'Kali Heros', 'On the Moon', ''),
(19, 'Kali Heros', 'On the Moon', ''),
(20, 'Kali Heros', 'On the Moon', ''),
(21, 'Kali Heros', 'On the Moon', ''),
(22, 'Kali Heros', 'On the Moon', ''),
(23, 'Kali Heros', 'On the Moon', ''),
(24, 'Kali Heros', 'On the Moon', ''),
(25, 'Kali Heros', 'On the Moon', ''),
(26, 'Kali Heros', 'On the Moon', ''),
(27, 'Kali Heros', 'On the Moon', ''),
(28, 'Kali Heros', 'On the Moon', ''),
(29, 'Kali Heros', 'On the Moon', ''),
(30, 'Kali Heros', 'On the Moon', ''),
(31, 'Kali Heros', 'On the Moon', ''),
(32, 'Kali Heros', 'On the Moon', ''),
(33, 'Kali Heros', 'On the Moon', ''),
(34, 'Kali Heros', 'On the Moon', ''),
(35, 'Kali Heros', 'On the Moon', ''),
(36, 'Kali Heros', 'On the Moon', ''),
(37, 'Kali Heros', 'On the Moon', ''),
(38, 'Kali Heros', 'On the Moon', ''),
(39, 'Kali Heros', 'On the Moon', ''),
(40, 'Kali Heros', 'On the Moon', ''),
(41, 'Kali Heros', 'On the Moon', ''),
(42, 'Kali Heros', 'On the Moon', ''),
(43, 'Kali Heros', 'On the Moon', ''),
(44, 'Kali Heros', 'On the Moon', ''),
(45, 'Kali Heros', 'On the Moon', ''),
(46, 'Kali Heros', 'On the Moon', ''),
(47, 'Kali Heros', 'On the Moon', ''),
(48, 'Kali Heros', 'On the Moon', ''),
(49, 'Kali Heros', 'On the Moon', ''),
(50, 'Kali Heros', 'On the Moon', ''),
(51, 'Kali Heros', 'On the Moon', ''),
(53, 'Lê Thanh Hòa', '226/10 Nguyễn Biểu P2 Q5', ''),
(54, 'Lê Thanh Hòa', '226/10 Nguyễn Biểu P2 Q5', '');

-- --------------------------------------------------------

--
-- Table structure for table `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id_nguoidung` varchar(10) NOT NULL,
  `tai_khoan` varchar(100) NOT NULL,
  `mat_khau` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `so_dien_thoai` varchar(10) NOT NULL,
  `quyen` varchar(100) NOT NULL,
  `tinh_trang_taikhoan` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id_nguoidung`, `tai_khoan`, `mat_khau`, `email`, `so_dien_thoai`, `quyen`, `tinh_trang_taikhoan`) VALUES
('admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'thanhhoa6621@gmail.com', '0706316621', 'admin', 1),
('1', 'customer1', '202cb962ac59075b964b07152d234b70', 'thanhhoa6621@gmail.com', '0706316621', 'customer', 1),
('2', 'customer2', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('3', 'customer3', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('4', 'customer4', '1', 'customer@gmail.com', '1234324', 'customer', 0),
('5', 'customer5', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('6', 'customer6', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('7', 'customer7', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('8', 'customer8', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('9', 'customer9', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('10', 'customer10', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('11', 'customer11', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('12', 'customer12', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('13', 'customer13', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('14', 'customer14', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('15', 'customer15', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('16', 'customer16', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('17', 'customer17', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('18', 'customer18', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('19', 'customer19', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('20', 'customer20', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('21', 'customer21', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('22', 'customer22', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('23', 'customer23', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('24', 'customer24', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('25', 'customer25', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('26', 'customer26', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('27', 'customer27', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('28', 'customer28', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('29', 'customer29', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('30', 'customer30', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('31', 'customer31', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('32', 'customer32', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('33', 'customer33', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('34', 'customer34', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('35', 'customer35', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('36', 'customer36', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('37', 'customer37', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('38', 'customer38', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('39', 'customer39', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('40', 'customer40', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('41', 'customer41', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('42', 'customer42', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('43', 'customer43', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('44', 'customer44', '1', 'customer@gmail.com', '1234324', 'customer', 0),
('45', 'customer45', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('46', 'customer46', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('47', 'customer47', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('48', 'customer48', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('49', 'customer49', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('50', 'customer50', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('51', 'customer51', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('52', 'customer52', '1', 'customer@gmail.com', '1234324', 'customer', 1),
('manager', 'manager', '202cb962ac59075b964b07152d234b70', 'manager@gmail.com', '0706316621', 'manager', 1),
('53', 'customer53', '202cb962ac59075b964b07152d234b70', 'thanhhoa6621@gmail.com', '0706316621', 'customer', 1),
('54', 'customer54nek', 'c8f3c7fc80cf9be66ea3bdf64ba1c82d', 'thanhhoa6621@gmail.com', '0706316621', 'customer', 1),
('nv001', 'nv0001', '202cb962ac59075b964b07152d234b70', 'thanhhoa6621@gmail.com', '0706316621', 'employee', 0);

-- --------------------------------------------------------

--
-- Table structure for table `nha_cung_cap`
--

CREATE TABLE `nha_cung_cap` (
  `id_nhacungcap` varchar(100) NOT NULL,
  `ten_nhacungcap` varchar(100) NOT NULL,
  `diachi_nhacungcap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nha_cung_cap`
--

INSERT INTO `nha_cung_cap` (`id_nhacungcap`, `ten_nhacungcap`, `diachi_nhacungcap`) VALUES
('1', 'Sun House', 'On the Earth'),
('2', 'Moon House Corp', 'On the Moon'),
('3', 'March House Corp', 'On the March'),
('4', 'Intracom Group', 'In VietNam');

-- --------------------------------------------------------

--
-- Table structure for table `nhom_san_pham`
--

CREATE TABLE `nhom_san_pham` (
  `id_nhomsanpham` varchar(10) NOT NULL,
  `ten_nhomsanpham` varchar(100) NOT NULL,
  `gioi_tinh` varchar(10) NOT NULL,
  `mieuta` longtext NOT NULL,
  `sosao_danhgia` int(5) NOT NULL,
  `soluot_danhgia` int(11) NOT NULL,
  `id_dongsanpham` varchar(10) NOT NULL,
  `mau_sanpham` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nhom_san_pham`
--

INSERT INTO `nhom_san_pham` (`id_nhomsanpham`, `ten_nhomsanpham`, `gioi_tinh`, `mieuta`, `sosao_danhgia`, `soluot_danhgia`, `id_dongsanpham`, `mau_sanpham`) VALUES
('1', 'Bitis Hunter Running Blue', 'Male', 'Từ cảm hứng bất tận của những chuyến đi tuổi trẻ, từ khát khao in dấu chân trên mọi nẻo đường, từ niềm tin của những chuyến đi giúp định nghĩa bản thân của những gã trai mơ, tạo nên phiên bản hợp tác đặc biệt Biti\'s Hunter x X-Men Go  ĐẾ LITEBOUNCE ĐỘC QUYỀN VỚI THIẾT KẾ DÀNH RIÊNG CHO BÀN CHÂN NGƯỜI VIỆT MANG ĐẾN TRẢI NGHIỆM CHẠY THOẢI MÁI NHẤT  LITEBOUNCE CUSHION Công nghệ đế 2 lớp độc quyền dành riêng cho giày chạy, là sự kết hợp tuyệt vời giữa độ êm và lực đẩy mạnh mẽ, như 1 ”lò xo” hấp thụ và phản hồi lực nhịp nhàng, giúp cho người chạy luôn sung sức.   TRUEFIT LITEKNIT UPPER Cấu trúc sợi dệt đan mềm mại, ôm trọn theo sự chuyển động của bàn chân. Thiết kế lỗ thoáng khí tối đa.   TRUEFIT INSOLE Đế lót 2 lớp kết hợp Ortholte và Eva, rất vừa vặn với cấu trúc phù hợp cho nhiều lòng bàn chân đặc trưng của người Việt, cùng độ êm được tính toán kĩ lưỡng nhất.', 5, 20, 'BHR', 'Đen'),
('10', 'Bitis Hunter Running Cyan', 'Male', 'No thing here', 0, 0, 'BHR', 'Cyan'),
('2', 'Bitis Hunter Running Orange', 'Female', 'Từ cảm hứng bất tận của những chuyến đi tuổi trẻ, từ khát khao in dấu chân trên mọi nẻo đường, từ niềm tin của những chuyến đi giúp định nghĩa bản thân của những gã trai mơ, tạo nên phiên bản hợp tác đặc biệt Biti\'s Hunter x X-Men Go  ĐẾ LITEBOUNCE ĐỘC QUYỀN VỚI THIẾT KẾ DÀNH RIÊNG CHO BÀN CHÂN NGƯỜI VIỆT MANG ĐẾN TRẢI NGHIỆM CHẠY THOẢI MÁI NHẤT  LITEBOUNCE CUSHION Công nghệ đế 2 lớp độc quyền dành riêng cho giày chạy, là sự kết hợp tuyệt vời giữa độ êm và lực đẩy mạnh mẽ, như 1 ”lò xo” hấp thụ và phản hồi lực nhịp nhàng, giúp cho người chạy luôn sung sức.   TRUEFIT LITEKNIT UPPER Cấu trúc sợi dệt đan mềm mại, ôm trọn theo sự chuyển động của bàn chân. Thiết kế lỗ thoáng khí tối đa.   TRUEFIT INSOLE Đế lót 2 lớp kết hợp Ortholte và Eva, rất vừa vặn với cấu trúc phù hợp cho nhiều lòng bàn chân đặc trưng của người Việt, cùng độ êm được tính toán kĩ lưỡng nhất.', 4, 30, 'BHR', 'Cam'),
('3', 'Converse Taylor Science Canvas Trainers', 'Male', 'Mẫu giày Converse Kid Science Canvas Trainers mô phỏng thế giới động vật với đa dạng lớp động vật, tạo nên một thế giới sinh học vô cùng phong phú. Mẫu giày thiết kế đơn giản và được trẻ em ưa chuộng nhiều, phù hợp với trẻ em từ 3 đến 10 tuổi.', 5, 10, 'CVK', 'Trắng'),
('4', 'Converse Chuck Taylor All Star Gamer Low-Top', 'Male', 'Mẫu giày Converse Kid Gamer Low Top sử dụng họa tiết đa màu sắc vui nhộn, được lấy cảm hứng từ những trò chơi điện tử ăn khách từ thập kỷ trước, được trẻ em trên khắp thế giới yêu thích. Thiết kế mang phong cách đơn giản nhưng cũng vô cùng thu hút, sẽ là một món quà đặc biệt để làm các bạn nhỏ bất ngờ.', 5, 2, 'CVK', 'Trắng'),
('5', 'Converse Chuck Taylor Classic Black-White Low Top', 'Female', 'Giày Converse classic thấp cổ mang lại cảm giác năng động, trẻ trung. Che khuyết điểm chân to ngang, với các bạn chân có thể chọn cao cổ sẽ không lo nhấc gót nữa. Giày phù hợp với những bạn nữ.', 5, 12, 'CVC', 'Đen Trắng'),
('6', 'Converse Chuck 70 Archive Paint Splatter High Top Black', 'Female', 'Chào hè bằng những thiết kế Converse Archive Paint Splatter, thương hiệu bóng rổ đình đám đã có dịp chinh phục các bạn trẻ đang hướng đến sự mới lạ và phong cách cá tính. Ứng dụng xu hướng Paint Splatter với hình ảnh những tia sơn màu được phun một cách không cần trật tự lên bản in cho thiết kế mới, Converse mang đến item đầy sắc màu để bạn “hết mình” với style trẻ trung, năng động nhất.', 5, 12, 'CV70s', 'Đen '),
('7', 'Converse Chuck 70 Archive Paint Splatter High Top White', 'Female', 'Chào hè bằng những thiết kế Converse Archive Paint Splatter, thương hiệu bóng rổ đình đám đã có dịp chinh phục các bạn trẻ đang hướng đến sự mới lạ và phong cách cá tính. Ứng dụng xu hướng Paint Splatter với hình ảnh những tia sơn màu được phun một cách không cần trật tự lên bản in cho thiết kế mới, Converse mang đến item đầy sắc màu để bạn “hết mình” với style trẻ trung, năng động nhất.', 5, 3, 'CV70s', 'Trắng'),
('8', 'Adidas Slip-on SuperStar', 'Male', 'PHIÊN BẢN KHÔNG DÂY VÀ SIÊU NHẸ CỦA ĐÔI GIÀY ADIDAS SUPERSTAR ĐẦY TÍNH BIỂU TƯỢNG.\r\nXO, mũi vỏ sò. Quai đan chéo cho bạn thêm một cách mới để mang đôi giày classic rất được yêu thích này. Hơn 50 năm trước, dòng giày adidas Superstar đã gây tiếng vang trên sân bóng rổ là mẫu giày cổ thấp bằng da đầu tiên. Các fan yêu thích giày trainer đã nhanh chóng xiêu lòng trước thiết kế mũi vỏ sò bằng cao su có vân nổi và từ đó đã mang đôi giày này tới biết bao nơi kỳ thú. Và không ai có thể quên được thập niên 80, thời mà hip hop vẫn còn là một hình thức nghệ thuật mới nổi và một nhóm bộ ba đến từ Hollis, Queens đã giơ cao đôi giày này khi biểu diễn trên sân khấu. Phiên bản slip-on này cho các fan một cách thức mới mẻ để di chuyển theo phong cách mũi vỏ sò đích thực.', 5, 11, 'ADS', 'Trắng'),
('9', 'Nike Air Max 97 Essential', 'Female', 'Với tính năng đồng nhất thiết kế tạo gợn sóng của đôi giày OG được lấy cảm hứng từ những con tàu siêu tốc của Nhật Bản. Giày Nike Air Max 97 Essential sẽ để bạn dồn hết tốc độ tối đa của bản thân về phía trước. Việc đưa vào dự án thiết kế đế giày đủ dài giúp cải thiện khi đang chạy và thêm một chút màu sáng và độ chi tiết sắc nét, nó đưa  bạn cảm giác đi trong thoải mái nhất ', 5, 3, 'NAX', 'Bạc');

-- --------------------------------------------------------

--
-- Table structure for table `phieu_nhap`
--

CREATE TABLE `phieu_nhap` (
  `id_phieunhap` varchar(100) NOT NULL,
  `id_nhanviennhap` varchar(10) NOT NULL,
  `id_nhacungcap` varchar(10) NOT NULL,
  `ngay_nhap` date NOT NULL,
  `tong_gia_nhap` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `phieu_nhap`
--

INSERT INTO `phieu_nhap` (`id_phieunhap`, `id_nhanviennhap`, `id_nhacungcap`, `ngay_nhap`, `tong_gia_nhap`) VALUES
('PN-609b75613c30d8.21739231', 'admin', '1', '2021-05-12', 10000000),
('PN-609bf5a8a85c33.15643328', 'manager', '2', '2021-05-12', 4000000);

-- --------------------------------------------------------

--
-- Table structure for table `phuongthuc_giaohang`
--

CREATE TABLE `phuongthuc_giaohang` (
  `id_phuongthuc` varchar(50) NOT NULL,
  `ten_phuongthuc` varchar(50) NOT NULL,
  `mota` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `phuongthuc_giaohang`
--

INSERT INTO `phuongthuc_giaohang` (`id_phuongthuc`, `ten_phuongthuc`, `mota`) VALUES
('GH-1', 'Giao hàng bình thường', 'Giao hàng bình thường'),
('GH-2', 'Giao hàng nhanh', 'Giao hàng nhanh');

-- --------------------------------------------------------

--
-- Table structure for table `quyen`
--

CREATE TABLE `quyen` (
  `id_quyen` varchar(100) NOT NULL,
  `ten_quyen` varchar(100) NOT NULL,
  `mieuta` varchar(100) NOT NULL,
  `so_luong` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quyen`
--

INSERT INTO `quyen` (`id_quyen`, `ten_quyen`, `mieuta`, `so_luong`) VALUES
('admin', 'Quyền quản trị', 'Quyền dành cho quản trị viên', 1),
('customer', 'Permission', 'For customers', 54),
('manager', 'Quyền quản lý', 'Quyền dành cho quản lý', 1),
('employee', 'Quyền nhân viên', 'Quyền dành cho nhân viên', 1),
('test1', 'test1', '', 0),
('test6', 'test6', '', 0),
('test7', 'test7', '', 0),
('test9', 'test9', '', 0),
('test10', 'test10', '', 0),
('test11', 'test11', '', 0),
('eqwf', 'sd', '123', 0),
('eqwf', 'sd', '1232', 0),
('travellers', 'Permission of travellers', 'Permission for travellers', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `id_sale` int(11) NOT NULL,
  `ten_sale` varchar(100) NOT NULL,
  `ngay_bat_dau` date NOT NULL,
  `ngay_ket_thuc` date NOT NULL,
  `giam_theo_percent` varchar(10) NOT NULL,
  `giam_theo_vnd` varchar(10) NOT NULL,
  `muc_gia_sale` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`id_sale`, `ten_sale`, `ngay_bat_dau`, `ngay_ket_thuc`, `giam_theo_percent`, `giam_theo_vnd`, `muc_gia_sale`) VALUES
(1, 'Sale for Summer', '2021-05-12', '2021-12-13', '25', '500000', ''),
(2, 'Sale for Autumn', '2021-05-12', '2021-08-13', '70', '2000000', ''),
(12, 'Sale for Tet', '2021-05-01', '2021-05-30', '30', '300000', ''),
(13, 'Sale for Noel', '2021-02-14', '2021-12-30', '30', '500000', ''),
(14, 'Sale for Anniversity 3th', '2021-08-20', '2021-12-30', '30', '500000', ''),
(15, 'Sale for Anniversity 2nd', '2020-08-20', '2020-12-30', '30', '500000', '');

-- --------------------------------------------------------

--
-- Table structure for table `san_pham`
--

CREATE TABLE `san_pham` (
  `id_sanpham` varchar(10) NOT NULL,
  `id_nhomsanpham` varchar(10) NOT NULL,
  `size` varchar(10) NOT NULL,
  `gia_sanpham` int(32) NOT NULL,
  `so_luong` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `san_pham`
--

INSERT INTO `san_pham` (`id_sanpham`, `id_nhomsanpham`, `size`, `gia_sanpham`, `so_luong`) VALUES
('1S31', '1', '31', 1000000, 0),
('1S33', '1', '33', 1550000, 10),
('2S31', '2', '31', 1500000, 25),
('9S33', '9', '33', 2000000, 25);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chuc_nang`
--
ALTER TABLE `chuc_nang`
  ADD PRIMARY KEY (`id_chucnang`);

--
-- Indexes for table `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`id_nguoidung`);

--
-- Indexes for table `nhom_san_pham`
--
ALTER TABLE `nhom_san_pham`
  ADD PRIMARY KEY (`id_nhomsanpham`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id_sale`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chuc_nang`
--
ALTER TABLE `chuc_nang`
  MODIFY `id_chucnang` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `id_nguoidung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `id_sale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
