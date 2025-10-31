import java.util.HashMap;
import java.util.Map;

public class Main {
    public static void main(String[] args) {
        int[] numeros = {4, 2, 4, 7, 11, 15};
        int objetivo = 8;

        int[] resultado = encontrarIndices(numeros, objetivo);

            if (resultado != null) {
                System.out.println("Indices encontrados: [" + resultado[0] + ", " + resultado[1] + "]");
            } else {
                System.out.println("No se encontraron números que sumen " + objetivo);
            }
        }
        public static int[] encontrarIndices(int[] numeros, int objetivo) {
            Map<Integer, Integer> mapa = new HashMap<>();

            for (int i = 0; i < numeros.length; i++) {
                    int diferencia = objetivo - numeros[i];
                    if (mapa.containsKey(diferencia)) {
                        return new int[]{mapa.get(diferencia), i};
                    }
                    mapa.put(numeros[i], i);
                }
                return null;
            }
    }