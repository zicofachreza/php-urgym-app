import 'package:dio/dio.dart';
import '../../../../core/network/dio_client.dart';
import '../models/login_response.dart';

class AuthRepository {
  final Dio _dio = DioClient.create();

  Future<LoginResponse> login(String email, String password) async {
    final response = await _dio.post(
      '/login',
      data: {'email': email, 'password': password},
    );

    return LoginResponse.fromJson(response.data);
  }
}
